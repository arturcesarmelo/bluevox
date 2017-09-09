<template>
	<div>
		<div class="page-title-with-border ">
			<div class="col-xs-6 col-sm-6 col-md-8">
				<h4> Dentistas
					<small class="text-muted"> cadastro</small>
				</h4>
			</div>
			<div class="hidden-xs col-sm-6 col-md-4">
				<ol class="breadcrumb">
					<li>
						<i class="glyphicon glyphicon-home"></i>
					</li>
					<li>Dentistas</li>
					<li>cadastro</li>
				</ol>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="page-body">
			<div class="col-md-3">
				<a @click="toggleShow">
					<img :src="imgDataUrl" class="img-thumbnail" v-if="imgDataUrl">
					<img src="alt/1.png" class="img-thumbnail" v-if="!imgDataUrl"
					width="200" height="200">
				</a>
				<my-upload 
					field="img" 
					:width="200"
					:height="200"
					url="/dentista-imagem" 
					:params="params" 
					:headers="headers" 
					:lang-ext="lang.pt" 
					:value.sync="show"
					:toggleShow.sync="toggleShow"
        			@crop-upload-success="cropUploadSuccess"
					img-format="png">
				</my-upload>
			</div>
			<div class="form-group col-md-9" :class="errors.nome ? 'error' : ''">
				<label>Nome</label>
				<input type="text" class="form-control" v-model="nome" />
				<span class="text-danger clearfix" v-if="errors.nome" v-for="err in errors.nome"> {{err}} </span>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="page-footer text-center">
			<router-link to="/dentistas" tag="a" class="btn btn-danger">
				<i class="glyphicon glyphicon-chevron-left"></i> Voltar à listagem
			</router-link>
			<button class="btn btn-primary" :disabled="canSubmit" @click="create()">
				<i class="glyphicon glyphicon-check"></i> Cadastrar dentista
			</button>
		</div>
	</div>
</template>

<script>
import myUpload from 'vue-image-crop-upload';
export default {
	data() {
		return {
			nome: '',
			image_url: '',
			errors: {},
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
					axios.post('dentistas', { nome: self.nome, image_url: self.image_url }).then(
						(res) => {
							localStorage.setItem('created', true);
							location.href = "#/dentistas/";
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
			this.imgDataUrl = this.image_url = jsonData.imgDataUrl;
		},
	}
}
</script>
