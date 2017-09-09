<template>
	<div>
		<div class="page-title-with-border ">
			<div class="col-md-8">
				<h3> Clínicas
					<small class="text-muted"> edição</small>
				</h3>
			</div>
			<div class="col-md-4 text-right">
				<ol class="breadcrumb">
					<li>Clínicas</li>
					<li>edição</li>
				</ol>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="page-body">
			<button class="btn btn-danger btn-sm pull-right btn-delete" @click="confirmation('remove')">
				<i class="glyphicon glyphicon-trash"></i>
			</button>
			<div class="col-md-6" v-if="!editing">
				<div class="well">
					<strong>NOME: </strong>
					<button class="btn btn-xs btn-rounded pull-right btn-primary" @click="editing = true">
						<i class="glyphicon glyphicon-pencil"></i>
					</button>
					<br /> {{dados.nome}}
				</div>
			</div>
			<div class="form-group col-md-6" v-if="editing">
				<button class="btn btn-xs btn-rounded pull-right btn-danger" @click="editing = false">
					<i class="glyphicon glyphicon-remove"></i>
				</button>
				<label>Nome</label>
				<input type="text" class="form-control" v-model="dados.nome" />
				<span class="text-danger clearfix" v-if="errors.dados" v-for="err in errors.dados"> {{err[0]}} </span>
			</div>
			<div class="col-md-6" v-if="dados.matriz_id">
				<div class="well">
					<strong>Matriz: </strong>
					<br /> {{dados.matriz.nome}}
				</div>
			</div>

			<div class="clearfix"></div>

			<template v-if="!dados.matriz_id">
				<div class="col-md-12">
					<p>Filiais</p>

					<hr>
				</div>

				<div class="form-group col-xs-9 col-sm-9">
					<label>Nome</label>
					<input type="text" class="form-control" v-model="filial.nome" />
					<span class="text-danger clearfix" v-if="errors.filial" v-for="err in errors.filial"> {{err[0]}} </span>
				</div>
				<div class="col-xs-3 col-sm-3" style="padding-top: 25px">

					<button class="btn btn-warning btn-block" @click="updateFilial(filial)" v-if="filial_id">
						<i class="glyphicon glyphicon-pencil"></i>
						<span class="hidden-xs hidden-sm">
							Atulaizar filial
						</span>
					</button>
					<button class="btn btn-success btn-block" :disabled="canSubmitFilial" @click="addFilial()" v-else>
						<i class="glyphicon glyphicon-plus"></i>
						<span class="hidden-xs hidden-sm">
							nova filial
						</span>
					</button>
				</div>

				<div class="clearfix"></div>

				<div class="col-md-12">
					<div class="table-content table-responsive" v-if="dados.filiais.length">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>Filial</th>
									<th class="col-md-1"></th>
								</tr>
							</thead>
							<tbody>
								<template v-for="filial in dados.filiais">
									<tr>
										<td>{{filial.nome}}</td>
										<td>
											<button class="btn btn-default btn-sm" @click="editFilial(filial)">
												<i class="glyphicon glyphicon-pencil"></i>
											</button>
											<button class="btn btn-default btn-sm" @click="removeFilial(filial)">
												<i class="glyphicon glyphicon-trash"></i>
											</button>
										</td>
									</tr>
								</template>
							</tbody>
						</table>
					</div>
				</div>

				<div class="col-md-12" v-if="dados.filiais.length == 0 ">
					<div class="alert alert-success col-md-12">
						<i class="glyphicon glyphicon-exclamation-sign"></i> Não há nenhuma filial cadastrada a essa Clínica. Preencha os dados e clique em
						<strong>Adicionar nova filial</strong>.
					</div>
				</div>
			</template>

			<div class="clearfix"></div>
		</div>
		<div class="page-footer text-center">
			<router-link to="/clinicas" tag="a" class="btn btn-danger">
				<i class="glyphicon glyphicon-chevron-left"></i> Voltar à listagem
			</router-link>
			<button class="btn btn-primary" :disabled="canSubmitCilinica" @click="confirmation()">
				<i class="glyphicon glyphicon-check"></i> Atualizar clínica
			</button>
		</div>
	</div>
</template>

<script>
import router from './../../router.js';
export default {
	data() {
		return {
			editing: false,
			dados: {
				nome: '',
				filiais: [],
			},
			filial_index: null,
			filial_id: null,
			filial: {
				nome: '',
			},
			base_path: '/clinicas/',
			errors: {
				filial: [],
				dados: []
			}
		}
	},
	computed: {
		/**
		 * variáveis computadas usadas para desabilitar o botão de atualizar/inserir
		 * caso eu não tenha o nome da clinica/filial sido digitado corretamente.
		 */
		canSubmitCilinica() {
			
				return !this.dados.nome && !this.editing
		},
		canSubmitFilial() {
			
				return !this.filial.nome
		}	
	},
	mounted() {
		/**
		 * função que, de iniício, já trás os dados da clinica solicitada
		 * usando o parâmetro da URL
		 */
		axios.get(this.base_path + this.$route.params.id).then(res => {
			this.dados = res.data;
		})
	},
	methods: {
		addFilial() {
			var filial = this.filial;
			filial.matriz_id = this.dados.id;
			this.errors.filial = [];
			axios.post(this.base_path, filial).then(
				(res) => {
					this.filial = "";
					this.dados.filiais.push(res.data);
				}, (error) => {
					this.errors.filial = error.response.data.errors
					swal("Erro!", error.response.data.message, "error");
				})
		},
		removeFilial(filial) {
			var index = this.dados.filiais.indexOf(filial);
			var self = this;
			swal({
				title: "Remover",
				text: "deseja realmente REMOVER a filial: " + filial.nome + "?",
				buttons: ['Não, cancelar', 'Sim, desejo'],
				icon: "warning",
				dangerMode: false,
				closeModal: false,
			}).then((isConfirmed) => {
				if (isConfirmed) {
					axios.delete(self.base_path + filial.id).then((res) => {
						self.dados.filiais.splice(index, 1);
						swal("Sucesso", 'filial alterada com sucesso!', "success");
					}, (res) => {
						swal("Erro!", error.response.data.message, "error");
					})
				} else {
					swal("Cancelado!", 'Algo deu errado', "error");
				}
			})
		},
		editFilial(filial) {
			this.registerIndexToEdit(filial);
			this.filial = copy(filial);
		},
		updateFilial(filial) {
			var self = this;
			swal({
				title: "Confirmação de atualização",
				text: "deseja realmente alterar a filial: " + filial.nome + "?",
				buttons: ['Não, cancelar', 'Sim, desejo'],
				icon: "warning",
				dangerMode: false,
				closeModal: false,
			}).then((isConfirmed) => {
				if (isConfirmed) {
					self.errors.filial = [];
					axios.put(self.base_path + filial.id, filial).then(
						(res) => {
							self.dados.filiais[self.filial_index].nome = filial.nome;
							self.resetIndex();
							swal("Sucesso", 'filial alterada com sucesso!', "success");
						}, (error) => {
							swal("Algo não correu bem. Verifique os campos do cadastro", {
								icon: "error",
							});
							self.errors.filial = error.response.data.errors
						})
				} else {
					swal("Cancelado!", 'Algo deu errado', "error");
				}
			})
		},
		confirmation(param) {
			var self = this;
			var word = 'Altualizar';
			if(param == "remove") {
				word = "Deletar";
			}
			swal({
				title: word.toUpperCase() + " clínica",
				text: "deseja realmente " + word + "  esta clínica?",
				buttons: ['Não, cancelar', 'Sim, desejo'],
				icon: "warning",
				dangerMode: false,
				closeModal: false,
			}).then((isConfirmed) => {
				if (isConfirmed) {
					if(param == 'remove') 
						self.removeClinica()
					else 
						self.updateClinica()
				} else {
					swal("Cancelado!", 'Algo deu errado', "error");
				}
			})
		},
		updateClinica() {
			var self = this;
			this.errors.dados = [];
			axios.put(self.base_path + self.$route.params.id, self.dados).then(
				(res) => {
					self.dados = res.data;
					swal("Sucesso", 'Clínica alterada com sucesso!', "success");
					self.editing = false;
				}, (error) => {
					swal("Algo não correu bem. Verifique os campos do cadastro", {
						icon: "error",
					});
					self.errors.dados = error.response.data.errors
				})
		},
		removeClinica() {
			var self = this;
			this.errors.dados = [];
			axios.delete(self.base_path + self.$route.params.id, self.dados).then(
				(res) => {
					localStorage.setItem('deleted', true);
					location.href = "#/clinicas/" ;
				}, (error) => {
					swal( error.response.data.message, {
						icon: "error",
					});
				})
		},
		registerIndexToEdit(filial) {
			this.filial_index = this.dados.filiais.indexOf(filial);
			this.filial_id = filial.id;
		},
		resetIndex() {
			this.filial = { nome: "" };
			this.filial_index = null;
			this.filial_id = null;
		},
	}
}
</script>
