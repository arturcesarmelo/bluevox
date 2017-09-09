<template>
	<div>
		<div class="page-title-with-border ">
			<div class="col-xs-6 col-sm-6 col-md-8">
				<h4> Clínicas
					<small class="text-muted"> cadastro</small>
				</h4>
			</div>
			<div class="hidden-xs col-sm-6 col-md-4">
				<ol class="breadcrumb">
					<li>
						<i class="glyphicon glyphicon-home"></i>
					</li>
					<li>Clínicas</li>
					<li>cadastro</li>
				</ol>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="page-body">
			<div class="form-group col-md-6" :class="errors.nome ? 'error' : ''">
				<label>Nome</label>
				<input type="text" class="form-control" v-model="nome" />
				<span class="text-danger clearfix" v-if="errors.nome" v-for="err in errors.nome"> {{err}} </span>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="page-footer text-center">
			<router-link to="/clinicas" tag="a" class="btn btn-danger">
				<i class="glyphicon glyphicon-chevron-left"></i> Voltar à listagem
			</router-link>
			<button class="btn btn-primary" :disabled="canSubmit" @click="create()">
				<i class="glyphicon glyphicon-check"></i> Cadastrar clínica
			</button>
		</div>
	</div>
</template>

<script>

export default {
	data() {
		return {
			nome: '',
			errors: {}
		}
	},
	computed: {
		canSubmit() {
			return !this.nome
		}
	},
	mounted() { },
	methods: {
		create() {
			var self = this;
			swal({
				title: "Confirmação",
				text: "Deseja realmente cadastrar " + self.nome + "?",
				icon: "warning",
				buttons: ["Não, cancelar.", "Sim, desejo."],
				dangerMode: false,
				closeModal: false,
			}).then((isConfirmed) => {
				if (isConfirmed) {
					axios.post('clinicas', { nome: self.nome }).then(
						(res) => {
							swal("Clínica cadastrada com sucesso", {
								icon: "success",
							});
							setTimeout(function() {
								localStorage.setItem('created', true);
								location.href = '#/clinicas/' + res.data.id + '/edit';
							}, 500);
						}, (error) => {
							swal("Algo não correu bem. Verifique os campos do cadastro", {
								icon: "error",
							});
							self.errors = error.response.data.errors
						})
				} else {
					swal("Cancelado", {
						icon: "error",
					});
				}
			});

		}
	}
}
</script>
