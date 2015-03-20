define([
    'jquery', 
    'underscore',
    'Backbone'
],
    function ($, _, Backbone ) {
        var ColorView = Backbone.View.extend({
            initialize: function() {
                console.log('inicializando colorview');
                this.model.on('change:checked', this.render, this);
                this.model.on('change:inactive', this.render, this);
            },
            events:{
               'click span':    'seleccionar'
            },
            seleccionar: function(e){
                e.preventDefault();
                e.stopPropagation();
                var self = this;
                if (this.model.get('inactive'))
                    return false;
                this.model.set({'checked':(!self.get('checked'))});
            },
            render:function () {
                var data = this.model.toJSON();
                this.$el.html(this.template({'color':data}));
                return this;
            },
            destroy_view: function() { 
                // COMPLETELY UNBIND THE VIEW 
                this.undelegateEvents(); 
                this.$el.removeData().unbind(); 
                // Remove view from DOM 
                this.remove(); 
                Backbone.View.prototype.remove.call(this); 
            }
        });
        return ColorView;
});



