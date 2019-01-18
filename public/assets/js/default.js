try{
    var check = document.getElementById("hosting_idService");
    var childs = check.children;
    for (var i = 0; i < childs.length ; i++)
    {
        childs[i].classList.add("custom-control");
        childs[i].classList.add("custom-checkbox");
        childs[i].classList.remove("form-check");

        childs[i].children[0].classList.add("custom-control-input");
        childs[i].children[0].classList.remove("form-check-input");

        childs[i].children[1].classList.add("custom-control-label");
        childs[i].children[1].classList.remove("form-check-label");
    }
} catch(error){}
try{
    var formCheck = document.querySelectorAll(".form-check");
    
    formCheck.forEach(function(div) {
        div.classList.add("custom-control");
        div.classList.add("custom-checkbox");
        div.classList.remove("form-check");

        div.children[0].classList.add("custom-control-input");
        div.children[0].classList.remove("form-check-input");

        div.children[1].classList.add("custom-control-label");
        div.children[1].classList.remove("form-check-label");
    });
} catch(error){}