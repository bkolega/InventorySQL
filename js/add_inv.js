//Call to php to either add item to inventory or update one
//Values passed in are type ("add" or "mod") and serial number
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

//Sends Data to Sale PHP to add sale information
//And update sold field for items sold in Item table.
function SellItem(sdate,poNum,sellerId,items,sold){
  $.post("php/sale.php",{
    invId: parseInt($('#inventoryID').val()),
    sdate: sdate,
    ponum: poNum,
    sellId: sellerId,
    items: items,
    sold: sold
  });
}

$(document).ready(function(){
  //Set value based on radio clicked for sold value for SellItem().
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
  
  //Passes Data to addModItem()
  $('#addItemData').click(function(){
    AddModItems("add",parseInt($('#addSerial').val()));
  });
  
  //Gathers Data and passes it sellItem()
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
    SellItem($('#regSale').val(),$('#regPONum').val(),parseInt($('#regUID').val()),item,soldVal);
  });
  
  //Passes serial number and inventory id to find an item
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
		//Adds information to update fields for easier modification
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
  
  //Passes Data to addModItem()
  $('#modFullItem').click(function(){
     AddModItems("mod",parseInt($('#modSerNum').val()));
  });
});
