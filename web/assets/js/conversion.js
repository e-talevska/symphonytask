(function($){
    $(function() {
        //open modal
        $('[data-open="modal"]').on('click', function(e)  {
            var targeted_popup = jQuery(this).attr('data-target');
            $(targeted_popup).fadeIn(100);

            e.preventDefault();
        });

        //close modal
        $('.popup-close').on('click', function(e)  {
            var targeted_popup = $(this).parents('.popup');
            $(targeted_popup).fadeOut(200);

            e.preventDefault();
        });

        //try to convert the odd
        $('.odds-converter-input').on('change', function () {
            oddsConverter(this);
        });

        //save the convertion in database
        $("#odds-converter").on('build', function (e) {
            $.ajax({
                url: '/conversion/save',
                data: e.detail,
                type: 'POST'
            });
        });
    });

    let isRunning = false;
    function oddsConverter(item) {
        if(isRunning) {
            return false;
        }
        isRunning = true;
        try {
            let c = new Converter(item.value, item.name);
            let moneyline_odds = item.form.elements['moneyline_odds'];
            let decimal_odds = item.form.elements['decimal_odds'];
            let fractional_odds = item.form.elements['fractional_odds'];
            moneyline_odds.value = c.moneyline;
            fractional_odds.value = c.fractional;
            decimal_odds.value = c.decimal;
            let event = new CustomEvent('build', { detail: c });
            item.form.dispatchEvent(event)
        } catch (e) {
            $('.odds-converter-input').not(item).val("-");
        }
        isRunning = false;
    }

    //The Converter constructor
    function Converter(value, type) {
        this.moneyline = undefined;
        this.decimal = undefined;
        this.fractional = undefined;
        this.type = type;

        let decimal;
        switch(type) {
            case 'moneyline_odds':
                this.moneyline = value;
                decimal = decimalFromMoneyline(value);
                break;

            case 'decimal_odds':
                this.decimal = value;
                decimal = parseFloat(value);
                break;

            case 'fractional_odds':
                this.fractional = value;
                decimal = decimalFromFraction(value);
                break;
            default:
                throw new Error('Invalid Type');
        }

        //check if valid value
        if(Number.isNaN(decimal) || decimal <= 0) {
            throw new Error('Invalid Value');
        }

        //convert the other two
        //in order not to change what the user has written

        this.moneyline = this.moneyline || moneyLineOddsFromDecimal(decimal);
        this.fractional = this.fractional || fractionalFromDecimal(decimal);
        this.decimal = this.decimal || roundDecimal(decimal);

        function decimalFromFraction(fractional) {
            let parts = fractional.split('/');
            parts = parts.map(function (item) {
                return Number(item);
            });

            if(parts.length == 2 && !Number.isNaN(parts[0]) && !Number.isNaN(parts[1]) && parts[1] != 0) {
                return((parts[0]/parts[1])+1);
            }
            return(false);
        }

        function decimalFromMoneyline(moneyLine) {
            return (moneyLine > 0) ? ((moneyLine/100)+1) : ((100/moneyLine*-1)+1)
        }


        function moneyLineOddsFromDecimal(decimal) {
            if (decimal >= 2) {
                return '+'+((decimal-1) * 100).toFixed(2);
            } else {
                return (-100/(decimal-1)).toFixed(2);
            }

            // decimal -= 1;
            // return (decimal < 1) ? ((100/decimal).toFixed(2)* (-1)) : ((decimal*100).toFixed(2));
        }

        function roundDecimal(decimal) {
            return (Math.round(decimal*100)/100).toFixed(2);
        }

        function fractionalFromDecimal(decimal) {
            decimal = parseFloat(decimal).toFixed(2);
            let num = (decimal-1) * 10000;
            let dom = 10000;

            num = Math.round(num);
            dom = Math.round(dom);

            let reducedValues = reduce(num,dom);
            num = reducedValues[0];
            dom = reducedValues[1];

            return(num+'/'+dom);
        }

        function reduce(a,b) {
            let newValues  = new Array(2);
            let gcd = greatestCommonDivisor(a,b);

            newValues[0] = a/gcd;
            newValues[1] = b/gcd;
            return newValues;
        }

        function greatestCommonDivisor(num1,num2) {
            let a, b;
            if (num1 < num2) {a = num2; b = num1;}
            else if (num1 > num2) {a = num1; b = num2;}
            else if (num1 == num2) {return num1;}
            while(true) {
                if (b == 0) {
                    return a;
                } else {
                    let temp = b;
                    b = a % b;
                    a = temp;
                }
            }
        }
    }
})(jQuery);
