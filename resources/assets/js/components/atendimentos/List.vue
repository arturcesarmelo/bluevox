<template>
   <div>
      <div class="page-title-with-border ">
         <div class="col-xs-6 col-sm-6 col-md-7">
            <h4> Atendimento
               <small class="text-muted"> listagem</small>
            </h4>
         </div>
         <div class="hidden-xs hidden-sm col-md-3">
            <ol class="breadcrumb">
               <li>Atendimento</li>
               <li>listagem</li>
            </ol>
         </div>
         <div class="col-xs-6 col-sm-6 col-md-2 text-right">
            <router-link to="/atendimentos/create" tag="button" class="btn btn-success">
               Cadastrar
            </router-link>
         </div>
         <div class="clearfix"></div>
      </div>
      <div class="page-body">
         <div class="col-md-12">
            <h4>
               <i class="glyphicon glyphicon-filter"></i> Filtros
            </h4>
            <div class="col-md-6">
               <label>Clínica</label>
               <select v-model="filtros.clinica_id" class="form-control">
                  <option v-for="clinica in clinicas" :value="clinica.id">{{clinica.nome}}</option>
               </select>
            </div>
            <div class="col-md-6">
               <label>Dentista</label>
               <select v-model="filtros.dentista_id" class="form-control">
                  <option v-for="dentista in dentistas" :value="dentista.id">{{dentista.nome}}</option>
               </select>
            </div>
            <div class="col-md-6">
               <label>Dia da semana</label>
               <select v-model="filtros.dia_semana" class="form-control">
                  <option v-for="dia in dias" :value="dia.value">{{dia.label}}</option>
               </select>
            </div>
            <div class="col-md-6">
               <label>Horário</label>
               <input type="time" class="form-control" v-model="filtros.hora" />
            </div>
            <div class="col-md-12 text-center" style="padding-top: 15px">
               <button class="btn btn-info btn-sm" @click="buscar()"> Filtrar busca</button>
            </div>
         </div>
         <div class="clearfix">&nbsp;</div>
         <div class="table-content table-responsive" v-if="response.data.length">
            <table class="table table-bordered table-striped table-hover table-condensed">
               <thead>
                  <tr>
                     <th class="col-md-1"></th>
                     <th>Clínica</th>
                     <th>Dentista</th>
                     <th>Dia</th>
                     <th>Hora início</th>
                     <th>Hora fim</th>
                  </tr>
               </thead>
               <tbody>
                  <template>
                     <tr v-for="atendimento in response.data">
                        <th class="col-md-1 text-center">
                           <router-link :to="'/atendimentos/' + atendimento.id + '/edit' " tag="a" class="btn btn-primary btn-sm">
                              <i class="glyphicon glyphicon-edit"></i>
                           </router-link>
                        </th>
                        <td>{{atendimento.clinica.nome}}</td>
                        <td>{{atendimento.dentista.nome}}</td>
                        <td>{{atendimento.dia_semana_text}}</td>
                        <td>{{atendimento.hora_inicio}}</td>
                        <td>{{atendimento.hora_fim}}</td>
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
         filtros: {
            clinica_id: '',
            dentista_id: '',
            dia_semana: '',
            hora: '',
         },
         clinicas: [],
         dentistas: [],
         dias: [
            { value: 1, label: 'Segunda' },
            { value: 2, label: 'Terça' },
            { value: 3, label: 'Quarta' },
            { value: 4, label: 'Quinta' },
            { value: 5, label: 'Sexta' },
            { value: 6, label: 'Sábado' },
            { value: 7, label: 'Domingo' },
         ],
         base_path: "/atendimentos/",
      }
   },
   mounted() {
      axios.get('/clinicas-all').then(res => {
         this.clinicas = res.data
      })
      axios.get('/dentistas-all').then(res => {
         this.dentistas = res.data
      })
      axios.get(this.base_path, this.filtros).then(res => {
         this.response = res.data;
      });
   },
   methods: {
      buscar() {
         var resource = this.prepareUrl()
         axios.get(resource).then(res => {
            this.response = res.data;
         });
      },
      getNext() {
         axios.get(this.response.last_page_url, this.filtros).then(res => {
            this.response = res.data;
         });
      },
      getPrevious() {
         axios.get(this.response.first_page_url, this.filtros).then(res => {
            this.response = res.data;
         });
      },
      getPage(page) {
         axios.get(this.response.path + "?page=" + page).then(res => {
            this.response = res.data;
         });
      },
      prepareUrl() {
         var keys = Object.keys(this.filtros);
         var str = this.base_path + "?";
         for(var i in keys) {
            if(this.filtros[keys[i]]) {
               if(i == 0)
                  str += keys[i]+"="+this.filtros[keys[i]];
               else
                  str += "&" + keys[i] + "=" + this.filtros[keys[i]];
            }
         }
         console.log(str);
         return str;
      }
   }

}
</script>
