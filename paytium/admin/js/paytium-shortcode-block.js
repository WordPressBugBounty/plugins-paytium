( function( blocks, i18n, element, components, editor ) {

    var el = element.createElement;
    var __ = i18n.__;
    var iconEl = el('svg', {xmlns: "http://www.w3.org/2000/svg", width: "25px", height: "25px", viewBox: "0 0 160 160", className:  "paytium-shortcode-icon"},
        el('image', { href: "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiBpZD0iTGF5ZXJfMSIgZGF0YS1uYW1lPSJMYXllciAxIiB2aWV3Qm94PSIwIDAgMjk1IDI5NSI+CiAgPGRlZnM+CiAgICA8c3R5bGU+CiAgICAgIC5jbHMtMSB7CiAgICAgICAgZmlsbDogdXJsKCNsaW5lYXItZ3JhZGllbnQpOwogICAgICB9CgogICAgICAuY2xzLTEsIC5jbHMtMiwgLmNscy0zLCAuY2xzLTQsIC5jbHMtNSwgLmNscy02LCAuY2xzLTcsIC5jbHMtOCwgLmNscy05IHsKICAgICAgICBzdHJva2Utd2lkdGg6IDBweDsKICAgICAgfQoKICAgICAgLmNscy0yLCAuY2xzLTMgewogICAgICAgIGZpbGwtcnVsZTogZXZlbm9kZDsKICAgICAgfQoKICAgICAgLmNscy0yLCAuY2xzLTYgewogICAgICAgIGZpbGw6ICMyMzIzMjM7CiAgICAgIH0KCiAgICAgIC5jbHMtMywgLmNscy04IHsKICAgICAgICBmaWxsOiAjZmZmOwogICAgICB9CgogICAgICAuY2xzLTQgewogICAgICAgIGZpbGw6IHVybCgjbGluZWFyLWdyYWRpZW50LTIpOwogICAgICB9CgogICAgICAuY2xzLTUgewogICAgICAgIGZpbGw6ICMxZDFjMWM7CiAgICAgIH0KCiAgICAgIC5jbHMtNyB7CiAgICAgICAgZmlsbDogI2MwNjsKICAgICAgfQoKICAgICAgLmNscy05IHsKICAgICAgICBmaWxsOiAjZmZmNDhkOwogICAgICB9CiAgICA8L3N0eWxlPgogICAgPGxpbmVhckdyYWRpZW50IGlkPSJsaW5lYXItZ3JhZGllbnQiIHgxPSIxNTIuNyIgeTE9IjUwLjE2IiB4Mj0iMTMwLjE5IiB5Mj0iMjIuNTkiIGdyYWRpZW50VHJhbnNmb3JtPSJ0cmFuc2xhdGUoMCAyOTYpIHNjYWxlKDEgLTEpIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+CiAgICAgIDxzdG9wIG9mZnNldD0iLjAyIiBzdG9wLWNvbG9yPSIjMWQxYzFjIiBzdG9wLW9wYWNpdHk9IjAiPjwvc3RvcD4KICAgICAgPHN0b3Agb2Zmc2V0PSIuNjgiIHN0b3AtY29sb3I9IiMxZDFjMWMiPjwvc3RvcD4KICAgIDwvbGluZWFyR3JhZGllbnQ+CiAgICA8bGluZWFyR3JhZGllbnQgaWQ9ImxpbmVhci1ncmFkaWVudC0yIiB4MT0iMTEzLjQzIiB5MT0iNDQuMzEiIHgyPSIxMzYuNTEiIHkyPSI2Ny4xMiIgZ3JhZGllbnRUcmFuc2Zvcm09InRyYW5zbGF0ZSgwIDI5Nikgc2NhbGUoMSAtMSkiIGdyYWRpZW50VW5pdHM9InVzZXJTcGFjZU9uVXNlIj4KICAgICAgPHN0b3Agb2Zmc2V0PSIuMDIiIHN0b3AtY29sb3I9IiMxZDFjMWMiIHN0b3Atb3BhY2l0eT0iMCI+PC9zdG9wPgogICAgICA8c3RvcCBvZmZzZXQ9Ii42OCIgc3RvcC1jb2xvcj0iIzFkMWMxYyI+PC9zdG9wPgogICAgPC9saW5lYXJHcmFkaWVudD4KICA8L2RlZnM+CiAgPHJlY3QgY2xhc3M9ImNscy05IiB3aWR0aD0iMjk1IiBoZWlnaHQ9IjI5NSIgcng9IjEzIiByeT0iMTMiPjwvcmVjdD4KICA8Zz4KICAgIDxwYXRoIGNsYXNzPSJjbHMtOCIgZD0iTTU2LjUxLDIyLjg3djEzNi40YzAsNi41Myw1LjM3LDExLjg3LDExLjkzLDExLjg3aDgxLjg5YzYxLjkxLDAsODguNzQtMzQuNDksODguNzQtODAuMjVTMjEyLjIzLDExLDE1MC4zMiwxMWgtODEuODljLTYuNTYsMC0xMS45Myw1LjM0LTExLjkzLDExLjg3WiI+PC9wYXRoPgogICAgPHBhdGggY2xhc3M9ImNscy03IiBkPSJNMTExLjMyLDQ0LjQ4djEwMC43OWg0NC4wN2M0MC4wMiwwLDU3LjM3LTIyLjUsNTcuMzctNTQuMzFzLTE3LjM2LTU0LjA3LTU3LjM3LTU0LjA3aC0zNi40NGMtNC4yMywwLTcuNjMsMy40NC03LjYzLDcuNloiPjwvcGF0aD4KICAgIDxwYXRoIGNsYXNzPSJjbHMtMiIgZD0iTTc5LjExLDE2MC4yOGg3MS4yMWM1MC4wNCwwLDc3LjY1LTI0LjYzLDc3LjY1LTY5LjMzLDAtMjUuNzYtMTAuMDgtNjkuMDMtNzcuNjUtNjkuMDNoLTcxLjIxYy02LjMyLDAtMTEuNDUsNS4xLTExLjQ1LDExLjR2MTE1LjU3YzAsNi4yOSw1LjEzLDExLjQsMTEuNDUsMTEuNFpNNzEuNDcsMzMuMzJjMC00LjIxLDMuNC03LjYsNy42My03LjZoNzEuMjFjMjcuNTUsMCw3My44Myw4LjQ5LDczLjgzLDY1LjIzLDAsNDIuMjYtMjYuMjQsNjUuNTMtNzMuODMsNjUuNTNoLTcxLjIxYy00LjIzLDAtNy42My0zLjM4LTcuNjMtNy42VjMzLjMyWiI+PC9wYXRoPgogICAgPHBhdGggY2xhc3M9ImNscy0zIiBkPSJNMTMzLjAxLDc2LjNjLTEuMzQtLjQ4LTIuNzQtLjcyLTQuMjYtLjcydi0uMDZoLTEwLjA5djI0LjM0aDEwLjIxYzEuODEsMCwzLjM4LS4zNiw0LjcyLS45NiwxLjM0LS42NiwyLjQ1LTEuNSwzLjMzLTIuNTguODgtMS4wOCwxLjUyLTIuNCwxLjk4LTMuOS40MS0xLjUuNjQtMy4xMi42NC00LjkyLDAtMi4wNC0uMjktMy43OC0uODItNS4yOC0uNTgtMS40NC0xLjM0LTIuNy0yLjI3LTMuNzItLjk5LS45Ni0yLjEtMS43NC0zLjQ0LTIuMjJaTTEzMC42MSw5NS4wN2MtLjc2LjI0LTEuNDYuMzYtMi4yMi4zNnYuMDZoLTQuNjF2LTE1LjM1aDMuNzNjMS4yOCwwLDIuMzMuMTgsMy4yMS41NC44OC4zNiwxLjU3Ljk2LDIuMSwxLjYyLjUzLjY2LjkzLDEuNTYsMS4xNywyLjUyLjIzLjk2LjM1LDIuMS4zNSwzLjMsMCwxLjM4LS4xOCwyLjQ2LS41MiwzLjQyLS4zNS45Ni0uODIsMS42OC0xLjM0LDIuMjgtLjUzLjYtMS4xNywxLjAyLTEuODcsMS4yNloiPjwvcGF0aD4KICAgIDxwYXRoIGNsYXNzPSJjbHMtOCIgZD0iTTE2MC42LDc1LjU5djQuNWgtMTIuNDl2NS4yMmgxMS40OXY0LjE0aC0xMS40OXY1Ljk0aDEyLjc4djQuNWgtMTcuOTd2LTI0LjM0aDE3LjY4di4wNloiPjwvcGF0aD4KICAgIDxwYXRoIGNsYXNzPSJjbHMtMyIgZD0iTTE4Ny4zMiw5OS45M2wtOC44Ny0yNC4zNGgtNS40M2wtOC45MywyNC4zNGg1LjI1bDEuODctNS40aDguODdsMS44MSw1LjRoNS40M1pNMTc1Ljc3LDgxLjU4bDIuOTgsOC45M2gtNi4xM2wzLjA5LTguOTNoLjA2WiI+PC9wYXRoPgogICAgPHBhdGggY2xhc3M9ImNscy04IiBkPSJNMTk1Ljc4LDc1LjU4djE5Ljg1aDExLjU1djQuNWgtMTYuNzR2LTI0LjM0aDUuMTlaIj48L3BhdGg+CiAgICA8cGF0aCBjbGFzcz0iY2xzLTYiIGQ9Ik05MC44NCwxMDAuMjljNi4zMiwwLDExLjQ0LTUuMTIsMTEuNDQtMTEuNDVzLTUuMTItMTEuNDUtMTEuNDQtMTEuNDUtMTEuNDQsNS4xMi0xMS40NCwxMS40NSw1LjEyLDExLjQ1LDExLjQ0LDExLjQ1WiI+PC9wYXRoPgogICAgPHBhdGggY2xhc3M9ImNscy02IiBkPSJNOTcuNjUsMTQ2LjA4Yy04Ljg2LDAtMTUuOTYtNy42NS0xNS45Ni0xNy4wNXYtMTMuMzFjMC00LjcsMy41NS04LjU2LDguMDEtOC41NnM4LjAxLDMuOCw4LjAxLDguNTZ2MzAuMzZoLS4wNloiPjwvcGF0aD4KICA8L2c+CiAgPHBhdGggY2xhc3M9ImNscy01IiBkPSJNMjU4LDE5OUgzOGMtMS4xLDAtMi0uOS0yLTJzLjktMiwyLTJoMjIwYzEuMSwwLDIsLjksMiwycy0uOSwyLTIsMloiPjwvcGF0aD4KICA8Zz4KICAgIDxwYXRoIGNsYXNzPSJjbHMtNSIgZD0iTTIwNS41OCwyNDguNzZjMC0xMy4zOCw5LjUyLTI1LjU3LDI1Ljk2LTI1LjU3czI2LjAzLDEyLjIsMjYuMDMsMjUuNTctOS41MiwyNS41Ny0yNi4wMywyNS41N2MtMTYuNDQsMC0yNS45Ni0xMi4yLTI1Ljk2LTI1LjU3Wk0yNDMuMTIsMjQ4Ljc2YzAtNi40NS00LjI1LTEyLjQtMTEuNTgtMTIuNHMtMTEuNTgsNS45Ni0xMS41OCwxMi40LDQuMzIsMTIuNDEsMTEuNTgsMTIuNDEsMTEuNTgtNS45NiwxMS41OC0xMi40MVoiPjwvcGF0aD4KICAgIDxwYXRoIGNsYXNzPSJjbHMtNSIgZD0iTTE5NS40NywyNTguMjZjNS40OC0zLjEyLDguNzctOS4wOCw4Ljc3LTE1LjY2LDAtOS43Ny03LjA2LTE4LjA5LTE4LjAyLTE4LjA5aC0yMy4wMXY0OC41MWgxNC4yNXYtMTIuNGgyLjY3bDguMTUsMTIuNGgxNi43OGwtOS41OS0xNC43NlpNMTgzLjM1LDI0OS40NmgtNS44OXYtMTMuNzJoNS45NmMzLjg0LDAsNi4zLDMuMTIsNi4zLDYuODZzLTIuNTQsNi44Ni02LjM3LDYuODZaIj48L3BhdGg+CiAgICA8cGF0aCBjbGFzcz0iY2xzLTUiIGQ9Ik05OC4xNywyMjQuNDZsLTguNTUsMjguOTEtOC4zNC0yOC45MWgtMTEuMzVsLTguNDEsMjguOTEtOC40OC0yOC45MWgtMTUuMDRsMTcuMjMsNDguNDJoMTIuMzhsOC0yNi4zNiw3LjkzLDI2LjM2aDEyLjQ0bDE3LjIzLTQ4LjQyaC0xNS4wNFoiPjwvcGF0aD4KICAgIDxwYXRoIGNsYXNzPSJjbHMtNSIgZD0iTTEzNC43NywyNjEuMDVoLS4wNGMtNS4zMywwLTkuMDctMy4yMi0xMC42Ny03LjQ4aDM2LjIxYy4yOS0xLjYuNDQtMy4yNC40NC00LjksMC0xMy4zNC05LjQ5LTI1LjUxLTI1Ljk1LTI1LjUydjEzLjE0YzUuMzYuMDEsOS4wNiwzLjIzLDEwLjY1LDcuNDhoLTM2LjE2Yy0uMjksMS42LS40NCwzLjI0LS40NCw0LjksMCwxMy4zNSw5LjUsMjUuNTMsMjUuOTEsMjUuNTNoLjA0di0xMy4xNVoiPjwvcGF0aD4KICAgIDxwYXRoIGNsYXNzPSJjbHMtMSIgZD0iTTEzNC43MywyNzQuMTljLjU2LDAsMS4xLS4wMiwxLjY1LS4wNCwzLjMzLS4xNyw2LjM2LS44NSw5LjA2LTEuOTQsMi43LTEuMSw1LjA3LTIuNiw3LjA4LTQuNDIsMi4wMS0xLjgyLDMuNjgtMy45NSw0Ljk3LTYuMywxLjE3LTIuMTMsMi4wMy00LjQ1LDIuNTctNi44NmgtMTUuMDljLS4zMS42NC0uNjcsMS4yNi0xLjA4LDEuODMtLjU2Ljc5LTEuMjIsMS41LTEuOTcsMi4xMS0uNzUuNjItMS41OSwxLjE0LTIuNTEsMS41NC0uOTMuNC0xLjkzLjY4LTMuMDIuODMtLjUzLjA3LTEuMDguMTEtMS42NS4xMS0zLjQsMC02LjE0LTEuMzEtOC4xLTMuMzZsLTkuODEsOS45MmM0LjM2LDQuMDMsMTAuNDEsNi41NywxNy45MSw2LjU3WiI+PC9wYXRoPgogICAgPHBhdGggY2xhc3M9ImNscy00IiBkPSJNMTM0LjczLDIyMy4xNGMtMTMuOTIsMC0yMi44Nyw4Ljc2LTI1LjI2LDE5LjU2aDE1LjA0YzEuOC0zLjcyLDUuMzQtNi40MiwxMC4yMi02LjQyLDMuODksMCw2LjkxLDEuNjgsOC44OCw0LjIybDkuOS0xMC4wMWMtNC40Mi00LjQ4LTEwLjc4LTcuMzUtMTguNzctNy4zNVoiPjwvcGF0aD4KICA8L2c+Cjwvc3ZnPg==" } )
    );

    blocks.registerBlockType( 'paytium/shortcode', {
        title: __( 'Paytium Code' ),
        icon: iconEl,
        category: 'widgets',
        keywords: ['ideal', 'payments', 'betaling'], // 3 keywords is a maximum: http://prntscr.com/m30m99
        attributes: {
            text: {
                type: 'string',
                source: 'text'
            },
            selectedOption: {
                type: 'string',
                source: 'selectedOption'
            },
        },

        supports: {
            customClassName: false,
            className: false,
            html: false
        },
        edit: function( props ) {
            var attributes = props.attributes,
                setAttributes = props.setAttributes,
                label = el("label", null,
                    __('Select an example form to get started:')
                ),
                shortcode = '',
                localContent = '',
                blankForm = el(components.Button, {
                        className:'blank-start',
                        onClick: function blank() {
                            return setAttributes({
                                text: shortcode,
                                selectedOption: 8
                            });
                        }
                    },
                    __('click here'),
                ),
                description = __(' to start from scratch without an example.' +
                    ' View all examples in the <a href="https://www.paytium.nl/handleiding/voorbeelden/" class="select-paytium-form-manual" target="_blank">manual</a>.');

            if ( Object.keys(attributes).length === 0 && attributes.constructor === Object) {

                localContent = el("div", {className: "wp-block-paytium-from-select"},
                    el(components.RadioControl, {
                        className: 'select-paytium-form',
                        label: label,
                        selected: attributes.selectedOption,
                        options: [
                            { label: 'Simple product or donation, static amount', value: 1 },
                            { label: 'Simple product or donation, open amount', value: 2 },
                            { label: 'Products with a quantity option', value: 3 },
                            { label: 'Dropdown with multiple amounts', value: 4 },
                            { label: 'Radio buttons with multiple amounts', value: 5 },
                            { label: 'Simple form with required email address', value: 6 },
                            { label: 'Extended form with name, email and address fields', value: 7 },
                            { label: 'Subscription/recurring payment', value: 8 },
                        ],
                        onChange: function onChange(text) {
                            switch (parseInt(text)) {
                                case 1:
                                    shortcode = '[paytium name="Form name" description="Payment description"]' +
                                        '\n[paytium_field type="label" label="€19,95" amount="19,95" /]'+
                                        '\n[paytium_button label="Pay" /]'+
                                        '\n[/paytium]';
                                    break;
                                case 2:
                                    shortcode = '[paytium name="Form name" description="Donations"]' +
                                        '\n[paytium_field type="open" label="Donation Amount:" default="25" /]' +
                                        '\n[paytium_total label="Donate" /]' +
                                        '\n[paytium_button label="Donate" /]' +
                                        '\n[/paytium]';
                                    break;
                                case 3:
                                    shortcode = '[paytium name="Form name" description="Payment description"]' +
                                        '\n[paytium_field type="label" label="Workshop tickets" amount="19.95" quantity="true" /]' +
                                        '\n[paytium_field type="label" label="T-shirts" amount="49.95" quantity="true" /]' +
                                        '\n[paytium_total label="Total" /]' +
                                        '\n[paytium_button label="Order now" /]' +
                                        '\n[/paytium]';
                                    break;
                                case 4:
                                    shortcode = '[paytium name="Form name" description="Payment description"]' +
                                        '\n[paytium_field type="dropdown" label="Options" options="9,95/19,95/29,95" options_are_amounts="true" /]' +
                                        '\n[paytium_total /]' +
                                        '\n[paytium_button label="Pay" /]' +
                                        '\n[/paytium]';
                                    break;
                                case 5:
                                    shortcode = '[paytium name="Form name" description="Payment description"]' +
                                        '\n[paytium_field type="radio" label="Options" options="9,95/19,95/29,95" options_are_amounts="true" /]' +
                                        '\n[paytium_total /]' +
                                        '\n[paytium_button label="Pay" /]' +
                                        '\n[/paytium]';
                                    break;
                                case 6:
                                    shortcode = '[paytium name="Form name" description="Payment description"]' +
                                        '\n[paytium_field type="email" label="Your email" required="true" /]' +
                                        '\n[paytium_field type="label" label="Product ABC for €19,95" amount="19,95" /]' +
                                        '\n[paytium_total /]' +
                                        '\n[paytium_button label="Pay" /]' +
                                        '\n[/paytium]';
                                    break;
                                case 7:
                                    shortcode = '[paytium name="Form name" description="Payment description"]' +
                                        '\n[paytium_field type="email" label="Email" required="true" /]' +
                                        '\n[paytium_field type="name" label="Name" required="true" /]' +
                                        '\n[paytium_field type="text" label="Address" required="true" /]' +
                                        '\n[paytium_field type="text" label="Postcode" required="true" /]' +
                                        '\n[paytium_field type="text" label="City" required="true" /]' +
                                        '\n[paytium_field type="text" label="Country" required="true" /]' +
                                        '\n[paytium_field type="label" label="Product ABC for €19,95" amount="19,95" /]' +
                                        '\n[paytium_total /]' +
                                        '\n[paytium_button label="Pay" /]' +
                                        '\n[/paytium]';
                                    break;
                                case 8:
                                    shortcode = '[paytium name="Subscription store" description="Some subscription"]' +
                                        '\n[paytium_subscription interval="1 days" times="99" /]' +
                                        '\n[paytium_field type="name" label="Volledige naam" /]' +
                                        '\n[paytium_field type="email" label="Jouw email" required="true" /]' +
                                        '\n[paytium_field type="label" label="Subscription €99" amount="99" /]' +
                                        '\n[paytium_total /]' +
                                        '\n[paytium_button label="Subscribe" /]' +
                                        '\n[/paytium]';
                                    break;
                                default:
                            }
                            return setAttributes({
                                text: shortcode,
                                selectedOption: text
                            });
                        }

                    }),
                    el("p", {className: 'select-paytium-form-description'},
                        el("span", {className: 'select-paytium-form-description'},
                            __('Or ')
                        ),
                        blankForm,
                        el("span", {className: 'select-paytium-form-description',dangerouslySetInnerHTML: { __html: description }})
                    ),
                )
            }
            else {
                localContent = el("div", {className: "wp-block-shortcode"},
                    el("label", null,
                        iconEl,
                        __('Paytium Code:')
                    ),
                    el(wp.blockEditor.PlainText, {
                        className: "input-control",
                        value: attributes.text,
                        placeholder: __('Write shortcode here…'),
                        onChange: function onChange(text) {
                            return setAttributes({
                                text: text
                            });
                        }
                    }),
                )
            }
            return (localContent)
        },
        save: function(props) {
            var attributes = props.attributes;
            return el(element.RawHTML, null, attributes.text);
        }
    } );
}(
    window.wp.blocks,
    window.wp.i18n,
    window.wp.element,
    window.wp.components,
    window.wp.editor
) );
