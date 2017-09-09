import VueRouter from 'vue-router';

let routes = [
   {
      path:'/',
      component: require('./components/Home.vue')
   },
   
   //clinicas
   {
      path:'/clinicas',
      component: require('./components/clinicas/List.vue')
   },
   {
      path:'/clinicas/create',
      component: require('./components/clinicas/Create.vue')
   },
   {
      path:'/clinicas/:id/edit',
      component: require('./components/clinicas/Edit.vue')
   },

   //filiais
   {
      path:'/filiais',
      component: require('./components/filiais/List.vue')
   },
   {
      path:'/filiais/create',
      component: require('./components/filiais/Create.vue')
   },
   {
      path:'/filiais/:id/edit',
      component: require('./components/filiais/Edit.vue')
   },

   //dentistas
   {
      path:'/dentistas/',
      component: require('./components/dentistas/List.vue'),
   },
   {
      path:'/dentistas/create',
      component: require('./components/dentistas/Create.vue'),
   },
   {
      path:'/dentistas/:id/edit',
      component: require('./components/dentistas/Edit.vue'),
   },

   //atendimentos
   {
      path:'/atendimentos/',
      component: require('./components/atendimentos/List.vue'),
   },
   {
      path:'/atendimentos/create',
      component: require('./components/atendimentos/Create.vue'),
   },
   {
      path:'/atendimentos/:id/edit',
      component: require('./components/atendimentos/Edit.vue'),
   },

   //documentos
   {
      path:'/documentos/',
      component: require('./components/documentos/List.vue'),
   },
   {
      path:'/documentos/importacao',
      component: require('./components/documentos/Import.vue'),
   },

   //plano
   {
      path:'/planos/',
      component: require('./components/planos/List.vue'),
   },
   {
      path:'/planos/create',
      component: require('./components/planos/Create.vue'),
   },
   {
      path:'/planos/:id/edit',
      component: require('./components/planos/Edit.vue'),
   },
   {
      path:'/credenciamento/',
      component: require('./components/planos/Credenciamento.vue'),
   },

   //beneficiario
   {
      path:'/beneficiarios/',
      component: require('./components/planos/Beneficiarios.vue'),
   },
   // {
   //    path:'/credenciamento/',
   //    component: require('./components/planos/Credenciamento.vue'),
   // },

];

export default new VueRouter({routes, linkActiveClass: 'active'});