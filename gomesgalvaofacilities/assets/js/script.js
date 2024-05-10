document.addEventListener("DOMContentLoaded", function(){
    var atual = 0;
    gtrack = document.querySelector(".glider-track");
    limite = 0
    document.querySelectorAll('.glider-track>div').forEach(() => {
        limite++
    });
    document.querySelector(".avancar").addEventListener("click", function(){
        atual += 1;
        
        if(atual < limite){
            gtrack.style.marginLeft = "-" + atual + "00vw";
        }else{
            gtrack.style.marginLeft = "0vw";
            atual = 0;
        }
    });

    document.querySelector(".voltar").addEventListener("click", function(){
        
        if(atual > 0){
            atual -=1;
            gtrack.style.marginLeft = "-"+atual + "00vw";
        }else{
            gtrack.style.marginLeft = "-"+(limite-1)+"00vw";
            atual = 4;
        }

    });

    document.onselectionchange = function() {
        var selection = window.getSelection();
        if(selection.anchorNode && selection.anchorNode.parentNode.nodeName === 'H3') {
            selection.anchorNode.parentNode.classList.add('selected');
        }else{
            document.querySelector('.selected').classList.remove('selected')
        }
    };
    

});