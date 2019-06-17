import Axios from "axios";

class Skillzone {
    dragged;
    cards = [];
    lines = [];
    constructor(data) {
        data.forEach(skill => {
            this.card(skill);
        });
    }

    card(cardData) {
        const card = {};
        card.id = cardData.id;
        card.title = cardData.title;
        card.top = this.random(200, window.innerHeight - 200);
        card.left = this.random(200, window.innerWidth - 200);
        this.cards.push(card);
    }

    random(min, max) {
        return Math.floor(Math.random() * (max - min)) + min;
    }
}

export default Skillzone;
