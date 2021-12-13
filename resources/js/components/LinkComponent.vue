<template>    
    <div class="container">
      <div class="text-center">
        <b-spinner v-if="loading" class="mb-6" label="Spinning"></b-spinner>
    </div>
      <b-table busy.sync="loading"
        :items="items" 
        :sort-by.sync="sortBy"
        :sort-desc.sync="sortDesc"
        :fields="fields"
        :filter="filter"
        empty-filtered-text="There are no records matching your request!"
        empty-text="There are no records matching your request!"
        striped responsive="sm">

      <template #cell(name)="row">
        <b-form-input v-if="selectedRow[row.index]" type="text" v-model="items[row.index].name"></b-form-input>
        <span v-else>{{row.value}}</span>
      </template>

       <template #cell(url)="row">
        <b-form-input v-if="selectedRow[row.index]" type="text" v-model="items[row.index].url"></b-form-input>
        <span v-else>{{row.value}}</span>
      </template>

      <template #cell(active)="row">
        <b-form-checkbox v-if="selectedRow[row.index]" type="text" v-model="items[row.index].active" name="check-button" switch size="lg"></b-form-checkbox>    
        <b-badge v-else pill :variant="row.item.active ? 'success' : 'danger'">{{ row.item.active ? 'Enabled' : 'Disabled' }}</b-badge>
      </template>

      <template #cell(view)="row">
          <a class="btn" :href="'/documentation?urls.primaryName=' + row.item.name" target="_blank">
              <i class="fa fa-external-link"></i>
          </a>
      </template>

      <template #cell(secretActions)="row">

          <a class="btn" variant="light" @click="sendInfo(row.item.id, row.item.name)" v-b-modal.modal-delete>
            <i class="fa fa-trash"></i>
          </a>

          <a class="btn" variant="light" v-if="!selectedRow[row.index]" @click="handleEditRow(row, false)">
              <i class="fa fa-edit"></i>
            </a>
          <b-button size="sm" pill variant="success" v-if="selectedRow[row.index]" @click="handleEditRow(row, true)">
              <i class="fa fa-check"></i>
          </b-button>

      </template>

    </b-table>
    <pagination :data="data" @pagination-change-page="getResults"></pagination>

    <!--delete modal-->
    <b-modal 
      hide-footer
      id="modal-delete" 
      title="Delete">
        Are you sure you want to delete this record? <br />
        <strong><em>{{ modalName }}</em></strong>

        <b-button class="mt-3" variant="outline-danger" block @click="deleteRecord(modalItem)">Delete</b-button>
        <b-button class="mt-1" variant="outline-primary" block @click="$bvModal.hide('modal-delete')">Cancel</b-button>
    </b-modal>
    </div>
</template>

<script>
export default {
  props: { 
    user_id: Number,
    user_name: String,
  },

  data() {
    return {
      loading: true,
      error: false,
      sortBy: '',
      filter: null,
      filterOn: ['Name', 'Url'],
      sortDesc: false,
      url: '',
      applicationPage: false,
      fields: [
          { label: 'Name', key: 'name', sortable: true },
          { label: 'Url', key: 'url', sortable: true },
          { label: 'Status', key: 'active' },
          { label: 'View', key: 'view' },
          { key: 'secretActions', label: 'Actions' },
          { key: 'edit', label: ''}
        ],
      items: [],
      modalItem: '',
      modalName: '',
      data: {},
      selectedRow: {}
    }
  },

  mounted() {
    this.$root.$on("getResults", () => {
      return this.getResults()
    });

    this.$root.$on("getToasts", (type, title, message) => {
      this.makeToast(type, title, message )
    });
  },

  created () {
    this.getResults()
    this.$root.$refs.url_component = this
  },

  methods: {

    handleEditRow(data, save = false) {
      if(save){
        this.updateRecord(data.item) 
      }
      
      this.selectedRow = {
         [data.index]: !this.selectedRow[data.index]
      }
    },

    sendInfo(item, name)
    {
      this.modalItem = item
      this.modalName = name
    },

    updateRecord(data)
    {
      const params = {
          id: data.id,
          name: data.name,
          url:  data.url,
          active: data.active,
          author: this.user_id
      };

      axios.post( route('admin.update'), params )
        .then( ( response ) => {
            if ( response.status === 200 ) {
                this.makeToast('success', 'Successfully updated item!', 'Great work!' )
            }

            if ( response.status !== 200 ) {
              this.makeToast('danger', 'Unable to update item!', 'Sorry, try again.' )
            }
        } )
        .catch( ( error ) => {
            this.makeToast('danger', 'Unable to update item!', error.response.data.error.message )
            console.log( error.response.data.error.message );                
        } )
    },

    deleteRecord(id)
    {
      const params = {
          id: id,
      };

      axios.post( route('admin.delete'), params )
        .then( ( response ) => {
            if ( response.status === 200 ) {
                this.items= this.items.filter(item=>item.id!=id)
                this.$bvModal.hide('modal-delete')
                this.makeToast('success', 'Successfully removed item!', 'You deleted an item, yay!' )
            }

            if ( response.status != 200 ) {
              this.makeToast('danger', 'Unable to delete item!', 'Error, check logs.' )
            }
        } )
        .catch( ( error ) => {
            this.makeToast('danger', 'Unable to delete item!', error )
            console.log( error );                
        } )
    },


    delayedLoading()
    {
      // We like to see spinners, sometimes the page
      // loads so fast, we dont get to see spinners!!
      setTimeout(() => this.loading = false, 1000)
    },

    getResults(page)
    {
      this.loading = true

      if (typeof page === 'undefined') {
          page = 1
      }

      this.url = route( 'list', { page: page } )

      axios.get( this.url )
        .then( response => {
          if ( response.status === 200 ) {
            this.delayedLoading()
            this.items = response.data.data;
            this.data = response.data         
          }
        } ).catch( error => {
            this.delayedLoading()
            this.error = true
        } );
    },

    // lets make some toast.
    makeToast(variant = null, title = null, content = null) {
      this.$bvToast.toast(`Message: ${content || 'default'}`, {
        title: `${title || 'default'}`,
        variant: variant,
        solid: true
      })
    }
  }
    
}
</script>
