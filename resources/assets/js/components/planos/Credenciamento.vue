<template>
	<div>
		<div class="page-title-with-border ">
			<div class="col-md-8">
				<h3> Credenciamento
					<small class="text-muted"> cadastro</small>
				</h3>
			</div>
			<div class="col-md-4 text-right">
				<ol class="breadcrumb">
					<li>Credenciamento</li>
					<li>edição</li>
				</ol>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="page-body">
			<div class="form-group col-md-6" v-if="registering">
				<label>Titular</label>
				<input type="text" class="form-control" v-model="titular.nome" />
			</div>
			<div class="form-group col-md-6" v-if="registering">
				<label>Nascimento</label>
				<input type="date" class="form-control" v-model="titular.nascimento" />
			</div>
			<div class="col-md-12 form-group">
				<label>Plano</label>
				<select v-model="plano_id" class="form-control">
					<option v-for="plano in planos" :value="plano.id">{{plano.nome}} </option>
				</select>
			</div>
			<div class="clearfix"></div>

			<template>
				<div class="col-md-12">
					<p>Dependentes</p>

					<hr>
				</div>

				<div class="form-group col-xs-4 col-sm-4">
					<label>Nome</label>
					<input type="text" class="form-control" v-model="dependente.nome" />
				</div>
				<div class="form-group col-xs-4 col-sm-4">
					<label>Nascimento</label>
					<input type="date" class="form-control" v-model="dependente.nascimento" />
				</div>
				<div class="col-xs-3 col-sm-3" style="padding-top: 25px">
					<button class="btn btn-success btn-block" @click="addDependente()">
						<i class="glyphicon glyphicon-plus"></i>
						<span class="hidden-xs hidden-sm">
							Novo dependente
						</span>
					</button>
				</div>

				<div class="clearfix"></div>

				<div class="col-md-12">
					<div class="table-content table-responsive">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>Dependente</th>
									<th>Nascimento</th>
									<th class="col-md-1"></th>
								</tr>
							</thead>
							<tbody>
								<template v-for="dependente in dependentes">
									<tr>
										<td>{{dependente.nome}}</td>
										<td>{{dependente.nascimento}}</td>
										<td>
											<button class="btn btn-default btn-sm" @click="removeDependente(dependente)">
												<i class="glyphicon glyphicon-trash"></i>
											</button>
										</td>
									</tr>
								</template>
							</tbody>
						</table>
					</div>
				</div>
			</template>

			<div class="clearfix"></div>
		</div>
		<div class="page-footer text-center">
			<router-link to="/clinicas" tag="a" class="btn btn-danger">
				<i class="glyphicon glyphicon-chevron-left"></i> Cancelar
			</router-link>
			<button class="btn btn-primary"  @click="confirmation()">
				<i class="glyphicon glyphicon-check"></i> Finalizar credenciamento
			</button>
		</div>
	</div>
</template>

<script>
import router from './../../router.js';
export default {
	data() {
		return {
			registering: true,
			dependente: {
				nome: '',
				nascimento:'',
			},
			titular: {
				nome: '',
				nascimento:'',
			},
			plano_id:'',
			dependentes: [],
			planos: [],
			base_path: '/credenciamentos/',
			errors: {},
		}
	},
	computed: {
		idadeTitular() {
			if(this.titular.nascimento)
				return 19;
			else
				0;
		}
	},
	mounted() {
		axios.get('planos-all').then(res => {
			this.planos = res.data
		})
	},
	methods: {
		addDependente() {
			this.dependentes.push(Object.assign({}, this.dependente));
			this.dependente = {
				nome:'',
				nascimento: ''
			}
		},
		removeDependente(dependente) {
			var index = this.dependentes.indexOf(dependente);
			this.dependentes.splice(index, 1);
		},
		confirmation() {
			swal({
            title: "Confirmação",
            text: "Deseja realmente credenciar ?",
            icon: "warning",
            buttons: ["Não, cancelar.", "Sim, desejo."],
            dangerMode: false,
            closeModal: false,
         }).then(isConfirmed => {
				if(isConfirmed) {
					this.create();
				} else {
					swal("Cancelado", {
						icon: "error",
					});
				}
			});
			
		},
		create() {
			var self = this;
			var data = {
				titular: self.titular,
				dependentes: self.dependentes,
			};
			data.titular.plano_id = self.plano_id;
			if(data.dependentes.length) {
				data.dependentes.map(function(val) {
					val.plano_id = self.plano_id
				});
			}
			axios.post(self.base_path, data).then(res=>{
				localStorage.setItem('created', true);
				location.href="#/beneficiarios/";
			}, error => {
				if(error.response.data.errors.nascimento)
					swal('Erro','Não é permitido titular menor de 18 anos', 'error');	
				else 
					swal('Erro','Preencha os campos obrigatórios', 'error');
			})
		}
		
	}
}
</script>
