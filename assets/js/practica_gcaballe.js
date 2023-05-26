//codi derivat del exemple dels ulls
//Aplico només el hover a la secció de la bruixola, que em sembla que queda millor així

function rotarBruixola(evento) {

    var b = document.querySelector("#bruixola");

    var graus = 0;
    var rad = 0;
    var posxrat = evento.clientX;
    var posyrat = evento.clientY;

    //posició de la bruxiola
    var pos = b.getBoundingClientRect();
    var posx = pos.left + pos.width / 2;
    var posy = pos.top + pos.height / 2;

    rad = -Math.atan((posx - posxrat) / (posy - posyrat));

    if (posy - posyrat < 0) {
        graus = rad * 180 / Math.PI + 180;
    } else {
        graus = (rad * 180 / Math.PI)
    } 

    b.style.transform = 'rotate(' + graus + 'deg)';
}