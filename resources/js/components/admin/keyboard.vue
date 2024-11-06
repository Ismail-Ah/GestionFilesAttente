<template>
    <div id="keyboard-component">
      <div id="numbers">
        <span v-for="number in numerals" :key="number.l">
          <button id="nums" @click="addLetter(number.l)">{{ number.l }}</button>
        </span>
      </div>
      <br>
      <div id="keys">
        <span v-for="letter in keys" :key="letter.l">
          <button id="key" @click="addLetter(letter.l)">{{ letter.l }}</button>
        </span>
      </div>
      <div id="sp">
        <span v-for="letter in special" :key="letter.k">
          <button id="special" @click="addLetter(letter.k)">{{ letter.k }}</button>
        </span>
      </div>
    </div>
  </template>
  
  <script>
  const KEYS = [
    { l: 'ض' }, { l: 'ص' }, { l: 'ق' }, { l: 'ف' }, { l: 'غ' }, { l: 'ع' }, { l: 'ه' }, { l: 'خ' }, { l: 'ح' }, { l: 'ج' },
    { l: 'ش' }, { l: 'س' }, { l: 'ي' }, { l: 'ب' }, { l: 'ل' }, { l: 'ا' }, { l: 'ت' }, { l: 'ن' }, { l: 'م' }, { l: 'ك' },
    { l: 'ظ' }, { l: 'ط' }, { l: 'ذ' }, { l: 'د' }, { l: 'ز' }, { l: 'ر' }, { l: 'و' }, { l: 'ة' }, { l: 'ث' }, { l: 'ى' },
    { l: 'Clear' }, { l: '!' }, { l: '.' }, { l: 'ئ' }, { l: 'ء' }, { l: 'ؤ' }, { l: 'لا' }, { l: '،' }, { l: '؟' }, { l: 'Delete' }
  ];
  
  const NUMERALS = [
    { l: '١' }, { l: '٢' }, { l: '٣' }, { l: '٤' }, { l: '٥' }, { l: '٦' }, { l: '٧' }, { l: '٨' }, { l: '٩' }, { l: '٠' }
  ];
  
  const SPECIAL_KEYS = [
    { k: 'Space' }
  ];
  
  var store = {
    state: {
      words: []
    },
    clearScreen: function () {
      return this.state.words.splice(0);
    },
    backspace: function () {
      var position = this.state.words.length;
      return this.state.words.splice(position - 1, 1);
    }
  };
  
  export default {
    name: 'Keyboard',
    props: {
      numerals: {
        type: Array,
        default: () => NUMERALS
      },
      keys: {
        type: Array,
        default: () => KEYS
      },
      special: {
        type: Array,
        default: () => SPECIAL_KEYS
      }
    },
    data() {
      return {
        words: store.state.words
      };
    },
    methods: {
      addLetter(letter) {
        if (letter === 'Clear') {
          store.clearScreen();
        } else if (letter === 'Delete') {
          store.backspace();
        } else if (letter === 'Space') {
          this.words.push(' ');
        } else {
          this.words.push(letter);
        }
      }
    }
  };
  </script>
  
  <style scoped>
  #keyboard-component {
    margin-top: 15px;
  }
  
  #key,
  #nums,
  #special {
    width: 90px;
    height: 50px;
    margin-left: 5px;
    margin-top: 5px;
    text-shadow: 2px 2px 2px lightgray;
    color: white;
    font-size: 25px;
    font-weight: bolder;
    background-color: black;
    border-radius: 5px;
    border: 1px solid darkgray;
    box-shadow: 5px 5px 10px gray;
  }
  
  #special {
    width: 585px;
  }
  
  #sp {
    margin-left: 20%;
    margin-top: 10px;
  }
  </style>
  