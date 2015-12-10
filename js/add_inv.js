function AddModItems(type,ser){
  $.post("php/addModItem.php",{
    method: type+"Item",
    invId: parseInt($('#inventoryID').val()),
    item: $('#'+type+'Item').val(),
    model: $('#'+type+'Model').val(),
    serial: ser,
    cat: $('#'+type+'Cat').val(),
    man: $('#'+type+'Man').val(),
    pdate: $('#'+type+'Date').val(),
    value: $('#'+type+'Value').val(),
    notes: $('#'+type+'Notes').val()
  });
}

function SellItem(sdate,poNum,sellerId,items,sold){
  $.post("php/sale.php",{
    sdate: sdate,
    ponum: poNum,
    sellID: parseInt(sellerId),
    items: items,
    sold: sold
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
    AddModItems("add",parseInt($('#addSerial').val()));
  });

  $('#sellItem').click(function(){
    var soldVal = null;
    if($('input[name="itemSold"][checked="checked"]').val() === "Y")
    {
      soldVal = 1;
    }
    else
    {
      soldVal = 0;
    }
    var item = $('#regItems').val();
    if(item.indexOf(",") > -1)
    {
      item = item.split(",");
    }
    SellItem($('#regSale').val(),$('#regPONum').val(),$('#regUID').val(),item,soldVal);
  });

  $('#findItem').click(function(){
    if(isNaN($('#modSerNum').val()))
    {
      alert("Serial Number must be numeric value only!");
    }
    else
    {
      $.post("php/addModItem.php",{
        method: "findItem",
        invId: parseInt($('#inventoryID').val()),
        item: null,
        model: null,
        serial: parseInt($('#modSerNum').val()),
        cat: null,
        man: null,
        pdate: null,
        value: null,
        notes: null
      })
      .done(function(data){
        data = $.parseJSON(data);
        if(data.error === undefined)
        {
          $('#modSerial').text($('#modSerNum').val());
          $('#modItem').val(data.item.itemName);
          $('#modValue').val(data.item.value);
          $('#modMan').val(data.item.man);
          $('#modCat').val(data.item.cat);
          $('#modDate').val(data.item.pdate);
          $('#modNotes').val(data.item.notes);
          $('#modModel').val(data.item.model);
        }
        else
        {
          alert(data.error);
        }
      });
    }
  });

  $('#modFullItem').click(function(){
     AddModItems("mod",parseInt($('#modSerNum').val()));
  });
});
