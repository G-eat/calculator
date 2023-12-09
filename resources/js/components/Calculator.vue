<template>
    <div class="calculator">
        <div v-if="show_history" class="calculator__history__wrap">
            <button @click="show_history = !show_history" class="btn--opaque history--back"><i class="fa fa-arrow-left"></i></button>
            <br>
            <div class="history__display">
                <div class="pad--right--10" v-for="history in histories">{{ history }}</div>
            </div>
        </div>

        <div v-else class="calculator__wrap">
            <div class="calculator__display">
                <div class="calculator__input pad--right--10" id="input">
                    {{ input }}
                </div>
                <div class="calculator__result">
                    {{ result }}
                </div>
            </div>
            <div class="calculator__functions">
                <button @click="deleteCalculation()" class="btn--opaque">C</button>
                <button @click="show_history = !show_history" class="btn--opaque"><i class="fa-solid fa-clock"></i></button>
                <button @click="calculator('()',false,true)" class="btn--opaque">()</button>
                <button @click="deleteLastInput()" class="btn--opaque"><i class="fa-solid fa-delete-left"></i></button>
                <button @click="calculator('7')">7</button>
                <button @click="calculator('8')">8</button>
                <button @click="calculator('9')">9</button>
                <button @click="calculator('*',true)" class="btn--opaque">*</button>
                <button @click="calculator('4')">4</button>
                <button @click="calculator('5')">5</button>
                <button @click="calculator('6')">6</button>
                <button @click="calculator('-',true)" class="btn--opaque">-</button>
                <button @click="calculator('1')">1</button>
                <button @click="calculator('2')">2</button>
                <button @click="calculator('3')">3</button>
                <button @click="calculator('+',true)" class="btn--opaque">+</button>
                <button @click="calculator('/',true)" class="btn--opaque">/</button>
                <button @click="calculator('0')">0</button>
                <button @click="calculator('.',true)" class="btn--opaque">.</button>
                <button @click="submit()" class="btn--opaque">=</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data : function(){
            return {
                show_history: false,
                histories: [],
                operations: ['+','-','*','/'],
                number_of_brackets_open: 0,
                the_number_already_have_one_dot: false,
                input: '',
                result: null
            }
        },
        methods:{
            calculator(value, is_operation = false, is_brackets = false) {
                // return result empty after every button clicked
                this.result = '';

                // if input is empty
                if(this.input == '') {
                    // if first char that user click its brackets add to input '(' and add +1 to number_of_brackets_open
                    // else if is operation we accept only '-' as first char
                    // and else is its a number so add number to input
                    if(is_brackets) {
                        this.input += '(';
                        this.number_of_brackets_open += 1;
                    } else if (is_operation && value == '-') {
                        this.input += '-';
                    } else if (!is_operation) {
                        this.input += value;
                    }
                } 
                // this was done to not let number to have two dots
                else if (value != '.' || (value == '.' && !this.the_number_already_have_one_dot)) {
                    // get last char of input
                    let lastChar = this.input.charAt(this.input.length - 1 );

                    // if next char that user click its brackets go to first if, if is_operation go to 'else if' and if isnt operation or bracket add number to input
                    if(is_brackets) {
                        // here we allow to open bracklets only if last char isnt '.'
                        if(lastChar != '.') {
                            // if in input there isnt any brackets
                            if(this.number_of_brackets_open == 0) {
                                // if last char isnt operator we add "*" before opening "("
                                if(!(this.operations.includes(lastChar))) {
                                    this.input += '*';
                                } 

                                this.input += '(';
                                this.number_of_brackets_open += 1;
                            } else {
                                // if last char in input its a number we close bracket and substract 1 from "number_of_brackets_open" variable else we open a new bracket and add 1 from "number_of_brackets_open"
                                if(!(this.operations.includes(lastChar) || lastChar == '(')) {
                                    this.input += ')';
                                    this.number_of_brackets_open -= 1;
                                } else if(this.operations.includes(lastChar) || lastChar == '(') {
                                    this.input += '(';
                                    this.number_of_brackets_open += 1;
                                }
                            }

                            this.the_number_already_have_one_dot = false;
                        }
                    } 
                    // if user clicks on operation and last char of input itn's operator or "." we add operator to input 
                    else if (is_operation) {
                        if(!(this.operations.includes(lastChar) || lastChar == '.')) {
                            if(value == '.') {
                                this.the_number_already_have_one_dot = true;
                            } else {
                                this.the_number_already_have_one_dot = false;
                            }
                            this.input += value;
                        }
                    } else {
                        this.input += value;
                    }
                }
            },
            deleteLastInput() {
                let lastChar = this.input.charAt(this.input.length - 1 );

                switch (lastChar) {
                    case '(':
                        this.number_of_brackets_open -= 1;
                        break;
                    case ')':
                        this.number_of_brackets_open += 1;
                        break;
                    case '.':
                        this.the_number_already_have_one_dot = false;
                        break;
                    default:
                        break;
                }

                this.input = this.input.slice(0, -1);
                this.result = null;
            },
            deleteCalculation() {
                this.input = '';
                this.number_of_brackets_open = 0;
                this.the_number_already_have_one_dot = false;
                this.result = null;
            },
            submit() {
                let lastChar = this.input.charAt(this.input.length - 1 );

                if(this.operations.includes(lastChar) || lastChar == '.' || this.number_of_brackets_open != 0) {
                    this.result = 'Invalid format';
                }  else if (this.input.length > 0) {
                    axios.post('/calculate' , {
                        input: this.input
                    })
                    .then(response => {
                        this.result = response.data.result;

                        let result = this.input + ' = ' + this.result;
                        this.histories.unshift(result);
                    })
                    .catch(error => {
                        console.log(error);
                    });
                }
                
            }
        },
        watch: {
            input: function () {
                var element = document.getElementById("input");
                element.scrollTop = element.scrollHeight;
            }
        }   
    }
</script>


<style scoped>
    ::-webkit-scrollbar {
    width: 0.1em;
    }
    
    ::-webkit-scrollbar-thumb {
    background-color: rgb(66, 66, 66);
    border-radius: 2px;
    }

    button {
        cursor: pointer;
    }

    .pad--right--10 {
        padding-right: 10px;
    }


    .calculator {
        max-width: 320px;
        box-shadow: 0 0 75px 30px rgba(205, 205, 205, 0.7);
    }

    .calculator__display {
        height: 6em;
        padding: 10px;
        color: rgba(255, 255, 255, 0.7);
        font-size: 2em;
        text-align: right;
    }

    .calculator__input {
        height: 4em;
        overflow: auto;
        word-wrap: break-word;
    }

    .calculator__result {
        word-break: break-all;
        overflow: auto;
        height: 1.5em;
        color: rgba(255, 255, 255, 0.5);
    }

    .calculator__functions {
        display: flex;
        flex-wrap: wrap;
        border: 1px solid rgba(255, 255, 255, 0.4);
        mix-blend-mode: overlay;
    }

    .calculator__functions button {
        flex: 0 1 25%;
        height: 70px;
        color: #111;
        font-size: 2em;
        mix-blend-mode: overlay;
        background: rgba(255, 255, 255, 0.4);
        border: 1px solid rgba(255, 255, 255, 0.4);
    }

    .calculator__functions button.btn--large {
        flex: 0 1 50%;
    }

    .calculator__functions button.btn--opaque {
        background: rgba(255, 255, 255, 0.2);
    }

    .calculator__history__wrap {
        width: 320px;
        height: 544px;
        padding: 10px;
        color: rgba(255, 255, 255, 0.7);
    }

    .history--back {
        font-size: 32px;
        background-color: transparent;
    }

    .history__display {
        text-align: right;
        font-size: 1.5em;
        overflow: auto;
        height: 490px;
    }
</style>