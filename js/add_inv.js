function AddModItems(type){
  $.ajax({
    type: "POST",
    url: "php/addModItem.php",
    method: type+"Item",
    item: $('#'+type+'Item').val(),
    model: $('#'+type+'Model').val(),
    serial: parseInt($('#'+type+'Serial').val()),
    cat: $('#'+type+'Cat').val(),
    man: $('#'+type+'Man').val(),
    pdate: new Date($('#'+type+'Date').val()),
    value: parseFloat($('#'+type+'Value').val()),
    notes: $('#'+type+'Notes').val()
  })
  .done(function(data)
  {
  
  });
}

function SellItem(sdate,poNum,sellerId,sold){
  $.ajax({
    type: "POST",
    url: "php/Sale.php",
    sdate: new Date(sdate),
    ponum: poNum,
    sellID: parseInt(sellerId),
    sold: sold
  })
  .done(function(data)
  {
  
  });
}

$(document).ready(function(){
  $('input[name="itemSold"]').click(function(){
    if($(this).val() === "Y")
    {
      $('input[name="itemSold"][value="N"]').removeAttr('checked');
      $('input[name="itemSold"][value="Y"]').attr('checked',"checked");
    }
    else
    {
      $('input[name="itemSold"][value="Y"]').removeAttr('checked');
      $('input[name="itemSold"][value="N"]').attr('checked',"checked");
    }
  });
  
  $('#addItemData').click(function(){
    AddModItems("add");
  });

  $('#sellItem').click(function(){
    var soldVal = null;
    if($('input[name="itemSold"][checked="checked"]').val() === "Y")
    {
      soldVal = true;
    }
    else
    {
      soldVal = false;
    }
    SellItem($('#regSale').val(),$('#regPONun').val(),$('#regUID').val(),soldVal);
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
        serial: $('#modSerNum').val(),
        cat: null,
        man: null,
        pdate: null,
        value: null,
        notes: null
      })
      .done(function(data){
        
      });
    }
  });

  $('#updateItem').click(function(){
     AddModItems("mod");
  });
});
