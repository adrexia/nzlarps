// https://www.cssscript.com/material-inspired-confirmalert-dialog-vanilla-javascript/

materialCallback = null;
function materialAlert( title, text, callback ){
    document.getElementById('materialmodal-title').innerHTML = title;
    document.getElementById('materialmodal-text').innerHTML = text;
    document.getElementById('materialmodal-buttonCANCEL').style.display = 'none';
    document.getElementById('materialmodal').classList.add("show");
    document.getElementById('materialmodal').classList.remove("hide");
    document.getElementById('contentwrapper').classList.add("materialmodal-isopen");

    materialCallback = callback;
}
function materialConfirm( title, text, callback ){
    materialAlert( title, text, callback );
    document.getElementById('materialmodal-buttonCANCEL').style.display = 'block';
}
function closeMaterialAlert(e, result){
    e.stopPropagation();
    document.getElementById('materialmodal').classList.add("hide");
    document.getElementById('materialmodal').classList.remove("show");
    document.getElementById('contentwrapper').classList.remove("materialmodal-isopen");


    if(typeof materialCallback == 'function') materialCallback(result);
}
