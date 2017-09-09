<template>
   <div>
      <div class="page-title-with-border ">
         <div class="col-md-8">
            <h3> Dentistas
               <small class="text-muted"> edição</small>
            </h3>
         </div>
         <div class="col-md-4 text-right">
            <ol class="breadcrumb">
               <li>Dentistas</li>
               <li>edição</li>
            </ol>
         </div>
         <div class="clearfix"></div>
      </div>
      <div class="page-body">
         <button class="btn btn-danger btn-sm pull-right btn-delete" @click="confirmation('remove')">
            <i class="glyphicon glyphicon-trash"></i>
         </button>
         
         <div class="col-md-6 form-group">
            <label>Clínica</label>
            <select v-model="dados.clinica_id" class="form-control">
               <option v-for="clinica in clinicas" :value="clinica.id">{{clinica.nome}}</option>
            </select>
         </div>
         <div class="col-md-6 form-group">
            <label>Dentista</label>
            <select v-model="dados.dentista_id" class="form-control">
               <option v-for="dentista in dentistas" :value="dentista.id">{{dentista.nome}}</option>
            </select>
         </div>
         <div class="col-md-4 form-group">
            <label>Dia da semana</label>
            <select v-model="dados.dia_semana" class="form-control">
               <option v-for="dia in dias" :value="dia.value">{{dia.label}}</option>
            </select>
         </div>
         <div class="col-md-4 form-group">
            <label>Hora início</label>
            <input type="time" class="form-control" v-model="dados.hora_inicio"/>
         </div>
         <div class="col-md-4 form-group">
            <label>Hora fim</label>
            <input type="time" class="form-control" v-model="dados.hora_fim"/>
         </div>

         <div class="clearfix"></div>
      </div>
      <div class="page-footer text-center">
         <router-link to="/dentistas" tag="a" class="btn btn-danger">
            <i class="glyphicon glyphicon-chevron-left"></i> Voltar à listagem
         </router-link>
         <button class="btn btn-primary" :disabled="canSubmit" @click="confirmation()">
            <i class="glyphicon glyphicon-check"></i> Atualizar atendimento
         </button>
      </div>
   </div>
</template>

<script>

export default {
   data() {
      return {
         editing: false,
         dados: {
            clinica_id: '',
            dentista_id: '',
            dia_semana: '',
            hora_inicio: '',
            hora_fim: '',
         },
         errors: {},
         dias: [
            { value: 1, label: 'Segunda' },
            { value: 2, label: 'Terça' },
            { value: 3, label: 'Quarta' },
            { value: 4, label: 'Quinta' },
            { value: 5, label: 'Sexta' },
            { value: 6, label: 'Sábado' },
            { value: 7, label: 'Domingo' },
         ],
         dentistas: [],
         clinicas: [],
         base_path: '/atendimentos/',
      }
   },
   computed: {
		/**
		 * variáveis computadas usadas para desabilitar o botão de atualizar/inserir
		 * caso eu não tenha o nome da clinica/filial sido digitado corretamente.
		 */
      canSubmit() {
         return !this.dados.clinica_id || !this.dados.dentista_id || !this.dados.dia_semana || !this.dados.hora_fim || !this.dados.hora_inicio
      },
   },
   mounted() {
      axios.get(this.base_path + this.$route.params.id).then(res=>{
         this.dados = res.data;
      })
      axios.get('/clinicas-all').then(res => {
         this.clinicas = res.data
      })
      axios.get('/dentistas-all').then(res => {
         this.dentistas = res.data
      })
   },
   methods: {
      confirmation(param = "update") {
         var self = this;
         var word = "alterar";
         if (param == 'remove') {
            var word = "deletar";
         }

         swal({
            title: word.toUpperCase() + " atendimento",
            text: "deseja realmente " + word + " este atendimento?",
            buttons: ['Não, cancelar', 'Sim, desejo'],
            icon: "warning",
            dangerMode: false,
            closeModal: false,
         }).then((isConfirmed) => {
            if (isConfirmed) {
               if (param == 'remove')
                  self.remove();
               else
                  self.update();
            } else {
               swal("Cancelado!", 'Algo deu errado', "error");
            }
         })
      },
      update() {
         var self = this;
         this.errors.dados = [];
         axios.put(self.base_path + self.$route.params.id, self.dados).then(
            (res) => {
               localStorage.setItem('updated', true);
               location.href = "#" + self.base_path;
            }, (error) => {
               swal("Algo não correu bem. Verifique os campos do cadastro", {
                  icon: "error",
               });
               self.errors.dados = error.response.data.errors
            })
      },
      remove() {
         var self = this;
         axios.delete(self.base_path + self.$route.params.id, self.dados).then(
            (res) => {
               localStorage.setItem('deleted', true);
               location.href = "#" + self.base_path;
            }, (error) => {
               swal(error.response.data.message, {
                  icon: "error",
               });
            })
      },
   }
}
</script>
