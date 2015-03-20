define([
    'underscore',
    'Backbone'
],
        function (_, Backbone) {
            var ColorModel = Backbone.Model.extend({
                defaults: {
                    color: '',
                    nombre: '',
                    checked: false,
                    inactive: false,
                    claseChecked: 'fa-check-square active',
                    claseNoChecked: 'fa-square',
                    claseInactive: 'inactive'
                }
            });
            return ColorModel;
        }
);
