<template>
   <div>
      <div class="page-title-with-border ">
         <div class="col-md-8">
            <h4> Filiais
               <small class="text-muted"> edição</small>
            </h4>
         </div>
         <div class="col-md-4">
            <ol class="breadcrumb">
               <li>
                  <i class="glyphicon glyphicon-home"></i>
               </li>
               <li>Filiais</li>
               <li>edição</li>
            </ol>
         </div>
         <div class="clearfix"></div>
      </div>
      <div class="page-body">
         <button class="btn btn-danger btn-sm pull-right btn-delete" @click="confirmation('remove')">
            <i class="glyphicon glyphicon-trash"></i>
         </button>
         <div class="form-group col-md-6" :class="errors.nome ? 'error' : ''">
            <label>Nome</label>
            <input type="text" class="form-control" v-model="dados.nome" />
            <span class="text-danger clearfix" v-if="errors.nome" v-for="err in errors.nome"> {{err}} </span>
         </div>
         <div class="form-group col-md-6" :class="errors.nome ? 'error' : ''">
            <label>Matriz</label>
            <select v-model="dados.matriz_id" class="form-control">
               <option v-for="matriz in matrizes" :value="matriz.id">{{matriz.nome}}</option>
            </select>
         </div>
         <div class="clearfix"></div>
      </div>
      <div class="page-footer text-center">
         <router-link to="/dentistas" tag="a" class="btn btn-danger">
            <i class="glyphicon glyphicon-chevron-left"></i> Voltar à listagem
         </router-link>
         <button class="btn btn-primary" :disabled="canSubmit" @click="confirmation('update')">
            <i class="glyphicon glyphicon-check"></i> Atualizar filial
         </button>
      </div>
   </div>
</template>

<script>
export default {
   data() {
      return {
         dados: {
            nome: '',
            matriz_id: '',
            matriz: {}
         },
         base_path: '/clinicas/',
         matrizes: [],
         errors: {}
      }
   },
   computed: {
      canSubmit() {
         return !this.dados.nome || !this.dados.matriz_id
      }
   },
   mounted() {
      axios.get('/matrizes/').then(res => {
         this.matrizes = res.data;
      })
      axios.get('/clinicas/' + this.$route.params.id).then(res => {
         this.dados = res.data;
      })
   },
   methods: {
      confirmation(param = 'update') {
         var self = this;
         var word = 'atualizar';
         if(param == 'remove')
            word = 'deletar';
         swal({
            title: "Confirmação",
            text: "Deseja realmente  " + word.toUpperCase() + " " + self.dados.nome + "?",
            icon: "warning",
            buttons: ["Não, cancelar.", "Sim, desejo."],
            dangerMode: false,
            closeModal: false,
         }).then((isConfirmed) => {
            if(param == 'update')
               self.update();
            if(param == 'remove')
               self.remove();
         });
      },
      update() {
         var self = this;
         axios.put(self.base_path + self.dados.id, self.dados).then(res=>{
            location.href="#/filiais/"
            localStorage.setItem('updated', true);
         })
      },
      remove() {
         var self = this;
         axios.delete(self.base_path + self.dados.id).then(res=>{
            location.href="#/filiais/"
            localStorage.setItem('deleted', true);
         })
      }
   }
}
</script>
