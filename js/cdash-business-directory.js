jQuery(document).ready(function($){

  equalheight = function(container){

  var currentTallest = 0,
       currentRowStart = 0,
       rowDivs = new Array(),
       $el,
       topPosition = 0;
   $(container).each(function() {

     $el = $(this);
     $($el).height('auto')
     topPostion = $el.position().top;

     if (currentRowStart != topPostion) {
       for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
         rowDivs[currentDiv].height(currentTallest);
       }
       rowDivs.length = 0; // empty the array
       currentRowStart = topPostion;
       currentTallest = $el.height();
       rowDivs.push($el);
     } else {
       rowDivs.push($el);
       currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
    }
     for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
       rowDivs[currentDiv].height(currentTallest);
     }
   });
  }

  $(window).load(function() {
    equalheight('#businesslist .business');
  });


  $(window).resize(function(){
    equalheight('#businesslist .business');
  });

  $('#cat').change(function(){
    if (this.selectedIndex !== 0) {
        window.location.href = this.value;
    }
 }) 
});

function getGridData () {
  // calc computed style
const gridComputedStyle = window.getComputedStyle(businesslist);

return {
  // get number of grid rows
  gridRowCount: gridComputedStyle.getPropertyValue("grid-template-rows").split(" ").length,
  // get number of grid columns
  gridColumnCount: gridComputedStyle.getPropertyValue("grid-template-columns").split(" ").length,
  // get grid row sizes
  gridRowSizes: gridComputedStyle.getPropertyValue("grid-template-rows").split(" ").map(parseFloat),
  // get grid column sizes
  gridColumnSizes: gridComputedStyle.getPropertyValue("grid-template-columns").split(" ").map(parseFloat)
}
}

window.addEventListener("DOMContentLoaded", outputGridData);
window.addEventListener("resize", outputGridData);

function outputGridData () {
  const gridData = getGridData();
  const columnCount = gridData.gridColumnCount;
  /*output.textContent = `
    Rows: ${gridData.gridRowCount}
    Columns: ${gridData.gridColumnCount}
    Rows sizes: ${gridData.gridRowSizes}
    Column sizes: ${gridData.gridColumnSizes}
  `;*/
  //document.getElementById("businesslist").className = "grid"+columnCount;
  //document.querySelector("#businesslist .business .description a").className = "grid"+columnCount;
  var images = document.querySelectorAll("#businesslist.responsive.cd_block .business .description a");
  //alert(images);
  for (i = 0; i < images.length; ++i) {
    images[i].className = "grid"+columnCount;
  }
}

