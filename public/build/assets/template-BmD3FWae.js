(function(a){a(function(){var i=a("body");a(".content-wrapper"),a(".container-scroller"),a(".footer");var s=a(".sidebar");function t(e){n===""?e.attr("href").indexOf("index.html")!==-1&&(e.parents(".nav-item").last().addClass("active"),e.parents(".sub-menu").length&&(e.closest(".collapse").addClass("show"),e.addClass("active"))):e.attr("href").indexOf(n)!==-1&&(e.parents(".nav-item").last().addClass("active"),e.parents(".sub-menu").length&&(e.closest(".collapse").addClass("show"),e.addClass("active")),e.parents(".submenu-item").length&&e.addClass("active"))}var n=location.pathname.split("/").slice(-1)[0].replace(/^\/|\/$/g,"");a(".nav li a",s).each(function(){var e=a(this);t(e)}),s.on("show.bs.collapse",".collapse",function(){s.find(".collapse.show").collapse("hide")}),a('[data-toggle="minimize"]').on("click",function(){i.toggleClass("sidebar-icon-only")}),a(".form-check label,.form-radio label").append('<i class="input-helper"></i>'),a.cookie("majestic-free-banner")!="true"?document.querySelector("#proBanner").classList.add("d-flex"):document.querySelector("#proBanner").classList.add("d-none"),document.querySelector("#bannerClose").addEventListener("click",function(){document.querySelector("#proBanner").classList.add("d-none"),document.querySelector("#proBanner").classList.remove("d-flex");var e=new Date;e.setTime(e.getTime()+24*60*60*1e3),a.cookie("majestic-free-banner","true",{expires:e})})})})(jQuery);
