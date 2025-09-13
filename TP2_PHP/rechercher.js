 function rechercher() {
    //variables
    let input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("recherche");
    filter = input.value.toUpperCase();
    table = document.getElementById("jolie");
    tr = table.getElementsByTagName("tr");
    // Parcourt toutes les lignes du tableau et masque celles qui ne correspondent pas à la recherche
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td");
        if (td.length > 0) {
            let match = false;
            for (let j = 0; j < td.length; j++) {
                txtValue = td[j].textContent || td[j].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    match = true;
                    break;
                }
            }
            if (match) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }   
        }
    }
    
 }
