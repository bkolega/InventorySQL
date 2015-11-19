function AddModItems(add,item,model,serial,cat,man,pdate,value,notes){
  if(add)
  {
    add = "addItem";
  }
  else
  {
    add = "updateItem"
  }
  $.ajax({
    type: "POST",
    url: "php/addModItem.php",
    type: add,
    item: item,
    model: model,
    serial: serial,
    cat: cat,
    man: man,
    pdate: pdate,
    value: value,
    notes: notes
  })
  .done(function(data)
  {
  
  });
}

function SellItem(sdate,poNum,sellerId,sold){
  
}

$('#addItemData').click(function(){

});

$('#sellItem').click(function(){

});

$('#findItem').click(function(){
  if(isNaN($('#modSerNum').val()))
  {
    alert("Serial Number must be numeric value only!");
  }
  else
  {
    $.ajax({
      type: "POST",
      url: "php/addModItem.php",
      type: "findItem",
      item: null,
      model: null,
      serial: $('#modSerNum'.val(),
      cat: null,
      man: null,
      pdate: null,
      value: null,
      notes: null
    })
    .done(function(data){
      
    });
});

$('#updateItem').click(function(){

});
