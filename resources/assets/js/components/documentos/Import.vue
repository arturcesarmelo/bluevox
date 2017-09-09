<template>
   <div>
      <div class="page-title-with-border ">
         <div class="col-xs-6 col-sm-6 col-md-8">
            <h4> Documentos
               <small class="text-muted"> importação</small>
            </h4>
         </div>
         <div class="hidden-xs col-sm-6 col-md-4">
            <ol class="breadcrumb">
               <li>
                  <i class="glyphicon glyphicon-home"></i>
               </li>
               <li>Documentos</li>
               <li>importação</li>
            </ol>
         </div>
         <div class="clearfix"></div>
      </div>

      <form enctype="multipart/form-data" @submit.prevent="importar" novalidate>
         <div class="page-body">
            <div class="col-md-6 form-group">
               <label>Selecione um ou mais arquivos .csv</label>
               <input type="file" class="form-control" name="file" accept="text/csv" />
            </div>
         </div>
         <div class="page-footer text-center">
            <router-link :to="base_path" tag="a" class="btn btn-danger">
               <i class="glyphicon glyphicon-chevron-left"></i> Voltar à listagem
            </router-link>
            <button type="submit" class="btn btn-primary">
               <i class="glyphicon glyphicon-file"></i> importar arquivo
            </button>
         </div>
      </form>
   </div>
</template>
<script>
export default {
   data() {
      return {
         base_path: "/documentos/",
         nome: 'csv',
      }
   },
   mounted() {

   },
   methods: {
      importar() {
         var form = document.querySelector('form');
         var formData = new FormData(form);
         axios.post(this.base_path, formData).then(res => {
            location.href="#" + this.base_path
         })
      }
   }
}
</script>

