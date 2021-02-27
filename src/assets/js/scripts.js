$.widget.bridge('uibutton', $.ui.button);

//receive calls from typescript code to update the layouts
var adminLTE = (function() {
  return {
    init: function() {
      $(function(){
        $.adminLTE.layout.activate();
        $.adminLTE.layout.fix();
        $.adminLTE.layout.fixSidebar();
      });
    }
  }
})(adminLTE||{});


