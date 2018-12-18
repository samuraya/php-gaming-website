import { service } from '../../js/ConnectFour/GameService.js'

window.Gaming = window.Gaming || {};
window.Gaming.ConnectFour = window.Gaming.ConnectFour || {};

window.Gaming.ConnectFour.ResignGameButton = class
{
    /**
     * @param {Node} button
     */
    constructor(button)
    {
        this.button = button;

        this.registerEventHandler();
    }

    onButtonClick(event)
    {
        event.preventDefault();

        let gameId = this.button.dataset.gameId;

        this.button.disabled = true;
        this.button.classList.add('loading-indicator');

        service.resign(gameId).then(() => {
            this.button.disabled = false;
            this.button.classList.remove('loading-indicator');
        }).catch(() => {
            // todo: Handle exception based on error.
            this.button.disabled = false;
            this.button.classList.remove('loading-indicator');
        });
    }

    registerEventHandler()
    {
        this.button.addEventListener('click', this.onButtonClick.bind(this));
    }
};
