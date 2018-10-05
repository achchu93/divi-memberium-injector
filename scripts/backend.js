// This script is loaded both on the frontend page and in the Visual Builder.

jQuery(function($) {
    $(document).ready(function(){
        ET_PageBuilder.Events.listenTo(ET_PageBuilder.Events, "et-pb-loading:ended", function(e){
            setTimeout(function () {
                var module = $("body").find(".et_pb_module_settings").data("module_type");
                if(typeof module !== "undefined" && module == "dmi_button"){
                    $("#et_pb_action_ids").memb_select2({
                        data: actionslist,  //actionlist is already defined global variable.
                        multiple: true,
                        minimumInputLength: 3,
                        sortResults: function(result, el, term){
                            return result.splice(0, 5);
                        },
                        containerCssClass: "dmi_button_select2_container",
                        dropdownCssClass: "dmi_button_select2"
                    });
                    $("#et_pb_tag_ids").memb_select2({
                        data: taglist.slice(1),  //actionlist is already defined global variable.
                        multiple: true,
                        minimumInputLength: 3,
                        sortResults: function(result, el, term){
                            return result.splice(0, 5);
                        },
                        containerCssClass: "dmi_button_select2_container",
                        dropdownCssClass: "dmi_button_select2"
                    });
                }
            }, 150);

        });
    });
});
