<div class="col-md-2 hidden-sm hidden-xs n-p">
   <ul class="list-group">
      <li class="list-group-item">
         Menus
      </li>
      <router-link to="/" tag="li" class="list-group-item" router-link-active exact>
         <i class="glyphicon glyphicon-home"></i> Home
      </router-link>
      <li class="list-group-item"  data-toggle="collapse" data-target="#clinicas">
         <i class="glyphicon glyphicon-map-marker"></i> Clinicas
      </li>
      <li class="collapse" id="clinicas" style="border: 1px solid #ecf0f1;">
         <ul class="inner-list">
            <router-link to="/clinicas"  tag="li" router-link-active class="pointer">
                Matrizes
            </router-link>
            <router-link to="/filiais" tag="li" router-link-active exact  class="pointer">
                Filiais
            </router-link>
            <router-link to="/atendimentos" tag="li" router-link-active exact  class="pointer">
               Atendimentos
            </router-link>
         </ul>
      </li> 
      <router-link to="/dentistas" tag="li" class="list-group-item" router-link-active exact>
         <i class="glyphicon glyphicon-user"></i> Dentistas
      </router-link>
      <router-link to="/documentos" tag="li" class="list-group-item" router-link-active exact>
         <i class="glyphicon glyphicon-list-alt"></i> Documentos
      </router-link>
      <li class="list-group-item"  data-toggle="collapse" data-target="#planos">
         <i class="glyphicon glyphicon-plus"></i> Plano de saúde
      </li>
      <li class="collapse" id="planos" style="border: 1px solid #ecf0f1;">
         <ul class="inner-list">
            <router-link to="/planos"  tag="li" router-link-active class="pointer">
                Planos
            </router-link>
            <router-link to="/beneficiarios" tag="li" router-link-active exact  class="pointer">
                Beneficiários
            </router-link>
            <router-link to="/credenciamento" tag="li" router-link-active exact  class="pointer">
               Credenciamento
            </router-link>
         </ul>
      </li> 
   </ul>
</div>