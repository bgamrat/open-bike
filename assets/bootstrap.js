import { startStimulusApp } from '@symfony/stimulus-bundle';
import chartJSController from './controllers/chartjs_controller.js';

const app = startStimulusApp();
// register any custom, 3rd party controllers here
app.register('chartjs_controller', chartJSController);