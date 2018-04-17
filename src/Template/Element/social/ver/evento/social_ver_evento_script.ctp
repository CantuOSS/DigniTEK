<script type="text/javascript">
    $(".form_datetime").datetimepicker({
        format: "dd MM yyyy - hh:ii",
        autoclose: true,
        todayBtn: true,
        startDate: "2013-02-14 10:00",
        minuteStep: 10
    });
    $('.form_datetime')
        .datetimepicker()
        .on('changeDate', function(ev){
            //console.log(ev);
            console.log("anio: " + ev.date.getFullYear());
            console.log("mes: " + ev.date.getMonth());
            console.log("dia: " + ev.date.getDate());
            console.log("hora: " + ev.date.getHours());
            console.log("minuto: " + ev.date.getMinutes());
            document.getElementsByName("inicio[year]")[0].value = ev.date.getFullYear();            
            document.getElementsByName("inicio[month]")[0].value = ("0" + (ev.date.getMonth()+1)).slice(-2);            
            document.getElementsByName("inicio[day]")[0].value = ("0" + ev.date.getDate()).slice(-2);            
            document.getElementsByName("inicio[hour]")[0].value = ("0" + ev.date.getHours()).slice(-2);            
            document.getElementsByName("inicio[minute]")[0].value = ("0" + ev.date.getMinutes()).slice(-2);            
            //document.getElementById("longitud").value = dato.lng();                   
        });    
</script>