<template>
   <div>
      <div class="page-title-with-border ">
         <div class="col-xs-6 col-sm-6 col-md-7">
            <h4> Beneficiarios <small class="text-muted"> listagem</small></h4>
         </div>
         <div class="hidden-xs hidden-sm col-md-3">
            <ol class="breadcrumb">
               <li>Beneficiarios</li>
               <li>listagem</li>
            </ol>
         </div>
         <div class="clearfix"></div>
      </div>
      <div class="page-body">
         <div class="table-content table-responsive" v-if="response.data.length">
            <table class="table table-bordered table-striped table-hover table-condensed">
               <thead>
                  <tr>
                     <th class="col-md-1"></th>
                     <th>Beneficiário</th>
                     <th>Titular</th>
                  </tr>
               </thead>
               <tbody>
                  <template>
                     <tr v-for="beneficiario in response.data">
                        <th class="col-md-1 text-center">
                           <router-link :to="'/beneficiarios/' + beneficiario.id + '/edit' " tag="a" class="btn btn-primary btn-sm">
                              <i class="glyphicon glyphicon-edit"></i>
                           </router-link>
                        </th>
                        <td>{{beneficiario.nome}}</td>
                        <td>
                           <template v-if="beneficiario.titular">
                              {{beneficiario.titular.nome}}
                           </template>
                        </td>
                     </tr>
                  </template>
               </tbody>
            </table>
            <div class="col-md-12 text-right">
               <ul class="pagination pagination-sm">
                  <li>
                     <a @click="getPrevious()">
                        &laquo;
                     </a>
                  </li>
                  <li v-for="n in response.last_page">
                     <a @click="getPage(n)">{{n}}</a>
                  </li>
                  <li>
                     <a @click="getNext()">
                        &raquo;
                     </a>
                  </li>
               </ul>
            </div>
         </div>
         <div class="alert alert-info" v-if="response.data.length == 0">
            <p class="text-center"> Buscando...</p>
         </div>
      </div>
   </div>
</template>

<script>
   export default {
      data() {
         return {
            response: {
               data: []
            },
            base_path: "/beneficiarios/",
         }
      },
      mounted() {
         axios.get(this.base_path).then(res=>{
            this.response = res.data;
         });
      },
      methods: {
         getNext() {
            axios.get(this.response.last_page_url).then(res=>{
               this.response = res.data;
            });
         },
         getPrevious() {
            axios.get(this.response.first_page_url).then(res=>{
               this.response = res.data;
            });
         },
         getPage(page) {
            axios.get(this.response.path + "?page=" + page ).then(res=>{
               this.response = res.data;
            });
         }
      }
      
   }
</script>
