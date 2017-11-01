/**
 * Created by Administrator on 2017/11/1 0001.
 * User: xkq
 * Date:  2017/11/1 0001.
 * Time: 22:49
 */

$.getJSON('areas.php?action=region', {regionid: 0}, function(data){
    var html = "<option value='0'>请选择省</option>"
    for(var i=0;i< data.length;i++){
        html = html + "<option value="+data[i]['areaid']+">"+data[i]['name']+"</option>";
    }
    $("#province").html(html);
});

function getRegion(region_code){
    if(region_code == "province"){
        var regionid = $("#province").val();
        var obj=document.getElementById("province");
        var region = obj.options[obj.selectedIndex].title;
        ajax_html(regionid,region_code);
    }else if(region_code == "city"){
        var regionid = $("#city").val();
        var obj=document.getElementById("city");
        var region = obj.options[obj.selectedIndex].title;
        ajax_html(regionid,region_code);
    }else{
        var regionid = $("#county").val();
        var obj=document.getElementById("county");
        var region = obj.options[obj.selectedIndex].title;
    }
    $("#region").val(region);
    $("#regionid").val(regionid);
}

function ajax_html(regionid,region_code){
    $.getJSON('areas.php?action=region', {regionid: regionid}, function(data){

        if(region_code == "province"){
            var html = "<option value='0'>请选择市</option>"
            for(var i=0;i< data.length;i++){
                html = html + "<option  value="+data[i]['areaid']+" title="+data[i]['joinname']+">"+data[i]['name']+"</option>";
            }
            $("#city").html(html);
        }else{
            var html = "<option value='0'>请选择区县</option>"
            for(var i=0;i< data.length;i++){
                html = html + "<option  value="+data[i]['areaid']+" title="+data[i]['joinname']+">"+data[i]['name']+"</option>";
            }
            $("#county").html(html);
        }

    });
}
