define([
    'underscore',
    'Backbone'
],
    function (_, Backbone) {
        var CronometroModel = Backbone.Model.extend({
            defaults: {
                contador: 0,
                semilla: 25
            },
            initialize: function () {
                var self = this;
                if(this.get('contador')==0){
                    this.set('contador', this.get('semilla')*60);
                }
                this.timerID = setInterval(function(){
                     self.tick();
                }, 1000); 
            },
            tick: function(){
                //console.log('contador +' + this.get('contador') );
                this.set('contador',this.get('contador') - 1);
                if(this.get('contador') == 0){
                    this.limpiarIntervalo();
                }
            },
            resetTimer: function(){  
                if (this.get('contador') > 0){  
                    this.limpiarIntervalo();  
                }  
            },
            limpiarIntervalo: function(){
                clearInterval(this.timerID);
            },
            getTimeFormat: function(){
                var minutos = Math.floor(this.get('contador')/60);
                var segundos = this.get('contador') - ( minutos * 60);
                var minFormat = ( (minutos<10)?'0'+minutos:minutos) + " min";
                var segFormat = ((segundos<10)?'0'+segundos:segundos) + " seg";
                if(minutos>0){
                    return minFormat + ' ' + segFormat;
                }else{
                    return segFormat;
                }
            }
        });
        return CronometroModel;
    });
