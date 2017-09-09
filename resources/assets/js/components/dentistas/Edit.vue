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
			<div class="col-md-3">
				<a @click="toggleShow">
					<img :src="dados.image_url" class="img-thumbnail" v-if="imgDataUrl || dados.image_url">
					<img src="alt/1.png" class="img-thumbnail" v-if="!imgDataUrl && !dados.image_url" width="200" height="200">
				</a>
				<my-upload field="img" :width="200" :height="200" url="/dentista-imagem" :params="params" :headers="headers" :lang-ext="lang.pt" :value.sync="show" :toggleShow.sync="toggleShow" @crop-upload-success="cropUploadSuccess" img-format="png">
				</my-upload>
			</div>
			<div class="form-group col-md-8">
				<label>Nome</label>
				<input type="text" class="form-control" v-model="dados.nome" />
				<span class="text-danger clearfix" v-if="errors.dados" v-for="err in errors.dados"> {{err[0]}} </span>
			</div>

			<div class="clearfix"></div>
		</div>
		<div class="page-footer text-center">
			<router-link to="/dentistas" tag="a" class="btn btn-danger">
				<i class="glyphicon glyphicon-chevron-left"></i> Voltar à listagem
			</router-link>
			<button class="btn btn-primary" :disabled="canSubmit" @click="confirmation()">
				<i class="glyphicon glyphicon-check"></i> Atualizar dentista
			</button>
		</div>
	</div>
</template>

<script>
import myUpload from 'vue-image-crop-upload';
export default {
	data() {
		return {
			editing: false,
			dados: {
				nome: '',
			},
			base_path: '/dentistas/',
			errors: {
				filial: [],
				dados: []
			},
			params: {
				token: $('meta[name="csrf-token"]').attr('content'),
				name: 'imagem'
			},
			show: false,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			imgDataUrl: '',
			lang:{
				pt: {
					hint: 'Clique ou arraste o arquivo para realizar o upload',
					loading: 'Carregando…',
					noSupported: 'Browser não suportado, por favor use IE10+ ou outros browsers',
					success: 'Upload realizado com sucesso!',
					fail: 'Upload falhou!',
					preview: 'Preview',
					btn: {
						off: 'Cancelar',
						close: 'Fechar',
						back: 'voltar',
						save: 'salvar'
					},
					error: {
						onlyImg: 'Imagem apenas',
						outOfSize: 'Image excede o limite: ',
						lowestPx: 'Tamanho da imagem é muito baixo. Espera-se pelo menos: '
					}
				}
			}
		}
	},
	components: {
		'my-upload': myUpload
	},
	computed: {
		/**
		 * variáveis computadas usadas para desabilitar o botão de atualizar/inserir
		 * caso eu não tenha o nome da clinica/filial sido digitado corretamente.
		 */
		canSubmit() {
			return !this.dados.nome
		},
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
		confirmation(param = "update") {
			var self = this;
			var word = "alterar";
			if (param == 'remove') {
				var word = "deletar";
			}

			swal({
				title: word.toUpperCase() + " dentista",
				text: "deseja realmente " + word + " este dentista?",
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
					location.href = "#/dentistas/";
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
					location.href = "#/dentistas/";
				}, (error) => {
					swal(error.response.data.message, {
						icon: "error",
					});
				})
		},
		toggleShow() {
			this.show = !this.show;
		},
		/**
		 * crop success
		 *
		 * [param] imgDataUrl
		 * [param] field
		 */
		cropSuccess(imgDataUrl, field) {
			this.imgDataUrl = imgDataUrl;
		},
		/**
		 * upload success
		 *
		 * [param] jsonData  server api return data, already json encode
		 * [param] field
		 */
		cropUploadSuccess(jsonData, field) {
			this.toggleShow();
			this.imgDataUrl = this.dados.image_url = jsonData.imgDataUrl;
		},
	}
}
</script>
