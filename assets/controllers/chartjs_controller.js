import { Controller } from '@hotwired/stimulus';
import { Chart } from 'chart.js';
import autocolors from 'chartjs-plugin-autocolors';
Chart.register(autocolors);

export default class chartJSController extends Controller {

    connect() {
        this.element.addEventListener('chartjs:pre-connect', this._onPreConnect);
    }

    disconnect() {
        // You should always remove listeners when the controller is disconnected to avoid side effects
        this.element.removeEventListener('chartjs:pre-connect', this._onPreConnect);
    }
    _onPreConnect(event) {
        /*
        event.detail.config.options = {...event.detail.config.options,
            plugins: {
                autocolors: {
                    mode: 'data'
                }
            }
        }*/

    }
};