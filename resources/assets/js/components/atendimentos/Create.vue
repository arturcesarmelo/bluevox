<template>
   <div>
      <div class="page-title-with-border ">
         <div class="col-xs-6 col-sm-6 col-md-8">
            <h4> Atendimento
               <small class="text-muted"> cadastro</small>
            </h4>
         </div>
         <div class="hidden-xs col-sm-6 col-md-4">
            <ol class="breadcrumb">
               <li>
                  <i class="glyphicon glyphicon-home"></i>
               </li>
               <li>Atendimento</li>
               <li>cadastro</li>
            </ol>
         </div>
         <div class="clearfix"></div>
      </div>
      <div class="page-body">
         <div class="col-md-6 form-group">
            <label>Clínica</label>
            <select v-model="clinica_id" class="form-control">
               <option v-for="clinica in clinicas" :value="clinica.id">{{clinica.nome}}</option>
            </select>
         </div>
         <div class="col-md-6 form-group">
            <label>Dentista</label>
            <select v-model="dentista_id" class="form-control">
               <option v-for="dentista in dentistas" :value="dentista.id">{{dentista.nome}}</option>
            </select>
         </div>
         <div class="col-md-4 form-group">
            <label>Dia da semana</label>
            <select v-model="dia_semana" class="form-control">
               <option v-for="dia in dias" :value="dia.value">{{dia.label}}</option>
            </select>
         </div>
         <div class="col-md-4 form-group">
            <label>Hora início</label>
            <input type="time" class="form-control" v-model="hora_inicio"/>
         </div>
         <div class="col-md-4 form-group">
            <label>Hora fim</label>
            <input type="time" class="form-control" v-model="hora_fim"/>
         </div>

      </div>
      <div class="page-footer text-center">
         <router-link to="/atendimentos/" tag="a" class="btn btn-danger">
            <i class="glyphicon glyphicon-chevron-left"></i> Voltar à listagem
         </router-link>
         <button class="btn btn-primary" :disabled="canSubmit" @click="confirmation()">
            <i class="glyphicon glyphicon-check"></i> Cadastrar atendimento
         </button>
      </div>
   </div>
</template>
<script>
export default {
   data() {
      return {
         base_path: '/atendimentos/',
         clinica_id: '',
         dentista_id: '',
         dia_semana: '',
         hora_inicio: '',
         hora_fim: '',
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
      }
   },
   mounted() {
      axios.get('/clinicas-all').then(res => {
         this.clinicas = res.data
      })
      axios.get('/dentistas-all').then(res => {
         this.dentistas = res.data
      })
   },
   computed: {
      canSubmit() {
         return !this.clinica_id || !this.dentista_id || !this.dia_semana || !this.hora_fim || !this.hora_inicio
      }
   },
   methods: {
      confirmation() {
         var self = this;
         swal({
            title: "Confirmação",
            text: "Deseja realmente cadastrar este atendimento?",
            icon: "warning",
            buttons: ["Não, cancelar.", "Sim, desejo."],
            dangerMode: false,
            closeModal: false,
         }).then(isConfirmed => {
            if (isConfirmed)
               self.create();
            else
               swal("Cancelado", {
                  icon: "error",
               });
         });
      },
      create() {
         var self = this;
         var data = {
            clinica_id: self.clinica_id,
            dentista_id: self.dentista_id,
            dia_semana: self.dia_semana,
            hora_fim: self.hora_fim,
            hora_inicio: self.hora_inicio,
         };

         axios.post(self.base_path, data).then(res => {
            localStorage.setItem('created', true);
            location.href = "#" + self.base_path
         }, error => {
            swal("Algo não correu bem. Verifique os campos do cadastro", {
               icon: "error",
            });
            self.errors = error.response.data.errors
         })
      }
   }

}
</script>

