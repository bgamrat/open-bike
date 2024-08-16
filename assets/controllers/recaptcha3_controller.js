/*
 * This file is part of open-bike.
 *
 * (c) Betsy Gamrat <betsy.gamrat@wirehopper.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import { Controller } from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static values = {
        siteKey: string
    }

    connect() {
        console.log("connect");
        grecaptcha.ready(function () {
            grecaptcha.execute(this.siteKey, {
                action: 'social'
            }).then(function (token) {
                //the token will be sent on form submit
                $('[name="captcha"]').val(token);
                //keep in mind that token expires in 120 seconds so it's better to add setTimeout.
            });
        });
    }
}
