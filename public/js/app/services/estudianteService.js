var servicesModule = angular.module('AppServices');
servicesModule.factory('estudianteService', ['$http', function ($http) {
    return {
        apiUrl: apiUrl,
        getAllEstudiantes2: function () {
            //return $http.get(this.apiUrl + 'estudiante/');
            return $http.get(this.apiUrl + 'estudiante/');
        },

        getAllEstudiantes: function (data) {
            //return $http.get(this.apiUrl + 'estudiante/');
            return $http.post(this.apiUrl + 'estudiantes_all', data);
        },
        getEstudiantesSearch: function (data) {
            //return $http.get(this.apiUrl + 'estudiante/');
            return $http.post(this.apiUrl + 'estudiantes_buscar/', data);
        },
        getEstudianteById: function (estudianteId) {

            return $http.get(this.apiUrl + 'estudiante/' + estudianteId);
        }, getColumnas: function () {
            return $http.get(this.apiUrl + 'estudiante_colums');
        }, getEstudiantesByFiltro: function (riesgoId) {
            return $http.get(this.apiUrl + 'estudiante_filtro/' + riesgoId);
        },
        getRiesgosByEstudiante: function (estudianteId) {
            return $http.get(this.apiUrl + 'personal/' + estudianteId);
        },
        getAnotacionById: function (codigo) {
            return $http.get(this.apiUrl + 'anotacion/' + codigo);
        },
        createAnotacion: function (data) {
            //return $http.get(this.apiUrl + 'estudiante/');
            return $http.post(this.apiUrl + 'anotacion/', data);
        },
        updateAntacion: function (codigo, data) {
            return $http.put(this.apiUrl + 'anotacion/' + codigo, data);
        },
        deleteAnotacion: function (codigo) {
            return $http.delete(this.apiUrl + 'anotacion/' + codigo);
        }


    };
}]);
