import Vue from 'vue';
import Router from 'vue-router';

Vue.use(Router);


export const routes = [{
        path: '/students',
        name: 'students',
        component: require('./components/modules/students/StudentsComponent').default
    },
    {
        path: '/courses',
        name: 'courses',
        component: require('./components/modules/courses/CoursesComponent').default,
    },
    {
        path: '/events',
        name: 'events',
        component: require('./components/modules/events/EventsComponent').default,
    },


    {
        path: '*',
        component: require('./components/layouts/404').default
    },
];

export default new Router({
    routes: routes,
    mode: 'history'
});