// This script is loaded both on the frontend page and in the Visual Builder.

jQuery(function($) {
    $(document).ready(function(){
        ET_PageBuilder.Events.listenTo(ET_PageBuilder.Events, "et-pb-loading:ended", function(e){
            console.log("et-pb-loading:ended");
            setTimeout(function () {
                var module = $("body").find(".et_pb_module_settings").data("module_type");
                if(typeof module !== "undefined" && module == "dmi_button"){
                    $("#et_pb_tag_ids").memb_select2({data:taglist, multiple:true});
                }
            }, 150);

        });
    });
});
