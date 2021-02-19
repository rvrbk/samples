// Number class to encapsulate operations
const Number = class {
    constructor(number) {
        this.number = parseInt(number);
        this.binary = '';
    }
    toBinary() { 
        let number = this.number;
        let remainder;
        let remainders = [];
       
        /* 
        Find the binary representation of an integer
        by dividing the integer by 2 and 'add' all the 
        remainders in reverse order until the sum is 0
        */
        while(number != 0) {
          // Find the reamainder
          remainder = number % 2;
          
          // Remember the remander
          remainders.push(remainder);
          
          // Divide the integer in order to keep calculating
          number = parseInt(number / 2); 
        }
      
        // Reverse and 'add' the remainders to construct the binary representation
        remainders.reverse().forEach((remainder) => {
          this.binary += '' + remainder + ''
        });
    }
};

// String class to encapsuate operations
const String = class {
    constructor(string) {
        this.string = string;
        this.reversed = '';
    }
    reverse() {
        // Reverse the string by splitting it into an array, reverse and join again 
        this.reversed = this.string.split('').reverse().join('');
    }
}

// Bringing it all together in a single function
const reverseBinary = function(integer) {
    let number = new Number(integer);
 
    // Convert to binary
    number.toBinary();

    let string = new String(number.binary);

    // Reverse the binary string
    string.reverse();

    return string.reversed; 
}

let reversed = reverseBinary(22);

const simpleReversionButWithoutMuchCode = function(integer) {
    // Making use of the build in toString() method, works but not very expandable
    return parseInt(integer).toString(2).split('').reverse().join('');
}

let simplereversed = simpleReversionButWithoutMuchCode(22);

// Display the results of both approaches
console.log(reversed, simplereversed);