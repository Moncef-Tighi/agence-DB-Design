const checkbox = document.getElementsByName("client");
const locataire = document.querySelector("#locataire");
const propriétaire = document.querySelector("#propriétaire");

locataire.style.display="none";
propriétaire.style.display="none";

checkbox.forEach(element=> {
    element.addEventListener("change", function(event){
        if (event.target===checkbox[0]) {
            locataire.style.display="block";
            propriétaire.style.display="none";
        } else if (event.target===checkbox[1]){
            locataire.style.display="none";
            propriétaire.style.display="block";

        }
    } )
})