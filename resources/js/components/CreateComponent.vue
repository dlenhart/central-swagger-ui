<template>
    <div>
        <a class="btn btn-dark" href="/"><i class="fa fa-home"></i></a>
        <a class="btn btn-success" v-b-modal.modal-create>Create <i class="fa fa-plus"></i></a>
        <a class="btn btn-secondary" href="/documentation" target="_blank">Swagger Documentation <i class="fa fa-external-link"></i></a>

        <b-modal 
            hide-footer
            id="modal-create" 
            title="Create">

            <form @submit.prevent="submit">
              <div class="form-row">
                  <div class="col-md-12">  
                      <div class="form-group" :class="{ 'form-group--error': $v.tname.$error }">
                          <label for="tname" class="">Name</label>
                          <input class="form-control" ref="tname" name="tname" v-model.trim="$v.tname.$model"/>
                      </div>
                      <div class="valid-feedback" v-if="!$v.tname.required">Name is required</div>
                      <div class="invalid-feedback" v-if="!$v.tname.minLength">Name must have at least {{$v.tname.$params.minLength.min}} letters.</div>
                  </div>
              </div>
              <br />
              <div class="form-row">
                  <div class="col-md-12">  
                      <div class="form-group" :class="{ 'form-group--error': $v.url.$error }">
                          <label for="url" class="">Url</label>
                          <input class="form-control" ref="details" name="url" v-model.trim="$v.url.$model" />

                      </div>
                      <div class="valid-feedback" v-if="!$v.url.required">Url is required</div>
                      <div class="valid-feedback" v-if="!$v.url.url">Url must be a valid URL.</div>
                  </div>
              </div>
              <br />
              <div class="form-row">
                  <div class="col-md-12">  
                    <label for="active">State</label>
                    <select name="active" id="active" class="form-control" v-model.trim="active">
                        <option value="1" selected="selected">Enabled</option>
                        <option value="0">Disabled</option>
                    </select>
                  </div>
              </div>
              <br /><br />
                <div class="form-row">
                  <b-button class="mt-2" type="submit" :disabled="submitStatus === 'PENDING'" variant="outline-success" block>Create</b-button>
                  <b-button class="mt-1" variant="outline-primary" block @click="$bvModal.hide('modal-create')">Cancel</b-button>
                  <div class="m-4"></div>
                  <p class="valid-feedback" v-if="submitStatus === 'OK'">Thanks for your submission! You will be redirected shortly</p>
                  <p class="invalid-feedback" v-if="submitStatus === 'ERROR'">Please fill the form correctly.</p>
                  <p class="valid-feedback" v-if="submitStatus === 'PENDING'">Sending...</p>
                </div>
            </form>            
        </b-modal>
    </div>
</template>
<script>
import { required, minLength, url } from 'vuelidate/lib/validators'

export default {
  data() {
    return {
      tname: '',
      url: '',
      active: 1,
      submitStatus: null
    }
  },

  validations: {
    tname: {
      required,
      minLength: minLength(4)
    },
    url: {
      required, url
    }
  },

  methods: {
    reloadResults()
    {
        this.$root.$emit("getResults")
    },

    callToasters(type = 'success', title = null, message = null)
    {
        this.$root.$emit("getToasts", type, title, message)
    },

    submit() {
      this.$v.$touch()
      if (this.$v.$invalid) {
        this.submitStatus = 'ERROR'
      } else {
        this.submitStatus = 'PENDING'

        let name = this.tname;
        let url = this.url;
        let active = this.active;

        axios.post('/admin/create', {
            name:   name,
            url:    url,
            active: active
          })
            .then((response) => {
                if(response.status == 200){

                  this.callToasters('success', 'Success', 'Successfully created new entry!')

                  setTimeout(() => {
                    this.submitStatus = 'OK';

                      this.$bvModal.hide('modal-create')
                      this.resetForm()
                      this.reloadResults()
                    
                  }, 500)
                    
                }else{
                    console.log('error')
                    this.submitStatus = 'ERROR'
                    this.callToasters('danger', 'Error', 'ERROR')
                }                
            })
            .catch((error) => {
                console.log(error)
                this.callToasters('danger', 'Error', error)
            })
      }
    },

    resetForm()
    {
      this.tname = ''
      this.url = ''
    }
  }
}
</script>

<style scoped>
.invalid-feedback, .valid-feedback {
    display: block
}
</style>