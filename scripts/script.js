document.addEventListener("DOMContentLoaded", function() {
    console.log("DOMContentLoaded event triggered");
    var inputDate = document.getElementById("inputDates");
    
    flatpickr(inputDate, {
        mode: "range",
        dateFormat: "d/m/Y",
        minDate: "today",
    });

});
document.addEventListener("DOMContentLoaded", function() {
    var inputDateFinVente = document.getElementById("dateFinVente");
    
    flatpickr(inputDateFinVente, {
        dateFormat: "d/m/Y",
        minDate: "today",
    });

});

if(document.getElementById("btnVoirPlus")){
    document.addEventListener("DOMContentLoaded", function() { //Fonction qui permet d'afficher la description entière 
        var showMoreBtn = document.getElementById("btnVoirPlus");
        var fullDescription = document.getElementById("DescriptionFull");
        var smallDescription = document.getElementById("DescriptionCourte");
    
        btnVoirPlus.addEventListener("click", function() {
            fullDescription.classList.toggle("hidden");
            DescriptionCourte.classList.toggle("hidden");
    
            if (fullDescription.classList.contains("hidden")) {
                btnVoirPlus.textContent = "Voir plus ⏷";
            } else {
                btnVoirPlus.textContent = "Voir moins ⏶";
                
            }
        });
    });
    
}


function submitFormCom() {
    document.getElementById('formCommentaire').submit(); // Soumettre le formulaire
}

function InputDateFlatpickr(lieuReception) {
    var dateLivraison = document.getElementById('inputDateR');
    var options = {};

    if (lieuReception === 'Marché') {
        options = {
            "enable": [
                function(date) {
                    return (date.getDay() === 4 || date.getDay() === 6);
                }
            ],
            "locale": {
                "firstDayOfWeek": 1, // Commencer la semaine le lundi
                "months": {
                    shorthand: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sept', 'Oct', 'Nov', 'Déc'],
                    longhand: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre']
                }
            },
            enableTime: true,
            dateFormat: "d/m/Y - H:i",
            time_24hr: true,
            minTime: "09:00",
            maxTime: "12:00",
            altInput: true,
            altFormat: "j F, Y à H:i",
            minDate: new Date().fp_incr(1)
        };
    } else {
        options = {
            "disable": [
                function(date) {
                    return (date.getDay() === 0 || date.getDay() === 6);
                }
            ],
            "locale": {
                "firstDayOfWeek": 1, // Commencer la semaine le lundi
                "months": {
                    shorthand: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sept', 'Oct', 'Nov', 'Déc'],
                    longhand: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre']
                }
            },
            enableTime: true,
            dateFormat: "d/m/Y - H:i",
            time_24hr: true,
            minTime: "09:00",
            maxTime: "18:00",
            altInput: true,
            altFormat: "j F, Y à H:i",
            minDate: new Date().fp_incr(1)
        };
    }

    flatpickr(dateLivraison, options);
}

document.addEventListener('DOMContentLoaded', function() {
    var initialLieuReception = document.getElementById('selectLieu').value;
    InputDateFlatpickr(initialLieuReception);
    console.log("DOMContentLoaded event triggered");
});

document.getElementById('selectLieu').addEventListener('change', function() {
    var lieuReception = this.value;
    InputDateFlatpickr(lieuReception);
});











function showPopup() {
    var popup = document.getElementById("popup");
    popup.style.display = "block";
}

// Fonction pour fermer le popup
function closePopup() {
    var popup = document.getElementById("popup");
    popup.style.display = "none";
}

// Exemple de déclenchement du popup lorsqu'une commande est effectuée
// Supposons que vous ayez une fonction pour traiter la commande, vous pouvez appeler showPopup() après cela
function passerCommande() {
    // Logique pour passer la commande
    // ...

    // Afficher le popup après avoir passé la commande
    showPopup();
}