/*
===========================================
 SOFTWARE PRODUCT PROPRIETARY LICENSE
===========================================

Fluffici z.s., IČO: 19786077, Year: 2024

DEVELOPER INFORMATION:
Developer Name: Vakea
Contact Information: vakea@fluffici.eu

TERMS AND CONDITIONS FOR USAGE

1. You may only use the Software Product in accordance with the accompanying documentation.
2. Reproduction and distribution of the Software Product are strictly prohibited, except through official channels defined and controlled by the copyright holder. Any illegal reproduction or distribution will be subject to legal action.
3. You may not modify or make derivative works of the Software Product.
4. You must retain all copyright, trademark, and proprietary notices on all copies of the Software Product made, if any.
5. You are not granted any rights to any trademarks or service marks of the Software Product.

THIS SOFTWARE PRODUCT IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.

===========================================
*/

function displayHeaders(platform) {
    const message1 = [
        `%c %c %c ${platform} platform | Fluffici, z.s. %c %c %c https://fluffici.eu/`,
        'background: #cbd0d3',
        'background: #3498db',
        'color: #ffffff; background: #2980b9;',
        'background: #3498db',
        'background: #cbd0d3',
        'background: #3498db'
    ];

    const message2 = [
        '%c %c %c Pozor, nikdy nesdílejte své tokeny nebo cookies! Vždy buďte opatrní, co sem píšete! NEPŘÍJÍMEJTE KONZOLOVÉ PŘÍKAZY TŘETÍCH STRAN! %c %c %c',
        'background: #cbd0d3',
        'background: #f39c12',
        'color: #ffffff; background: #e67e22;',
        'background: #f39c12',
        'background: #cbd0d3',
        'background: #ffffff'
    ];

// Do not remove the author header.
    const message3 = [
        '%c %c %c © FLUFFICI Z.S 2024, All Right Reserved. | WebAPP Made by @VakeaTheFolfynx for Fluffici! %c %c %c https://fluffici.eu/',
        'background: #cbd0d3',
        'background: #3498db',
        'color: #ffffff; background: #2980b9;',
        'background: #3498db',
        'background: #cbd0d3',
        'background: #3498db'
    ];

    console.log.apply(console, message1);
    console.log.apply(console, message3);
    console.log.apply(console, message3);
    console.log.apply(console, message2);
    console.log.apply(console, message2);
}
