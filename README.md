# Rubid

First named WRL for Worst Readable Language, this was renamed Rupid for no reason.

## How it works

The memory is a stack. With Rubid, you can just manipulate this stack.

```
u - increase the top of stack by 1
d - decrease the top of stack by 1
u*X - X must be a number between 0 and 9 included - apply u X time
d*X - X must be a number between 0 and 9 included - apply d X time
mX - X must be a number between 0 and 9 included - multiply top of stack by X

A - addition between top of stack and next element
C - print top of stack as an ASCII character
D - division between top of stack and next element
M - multiplication between top of the stack and next element
N - print a next line \n
P - print the top of stack as it is in memory
S - substraction between top of the stack and next element
U - ask for user input
W - short to print a whitespace

. - reset the stack
; - push 0 to the top
(code) - execute code for the exact number of time in the top of the stack
! - print the stack state
- - pop the element
```

### More elements

```
.u*5(u*9m2;)!

. - reset the memory
u*5 - Increase the stack top 5 times (this is our counter for the next element)
( - begin of loop while counter different of 0, execute 
    u*9 - Increase the stack top 9 times
    m2 - multiply it by 2
    ; - push 0 at top of stack
) - end of loop
! - print all stack state
```

The for always create a new stack element. The counter still stored in memory and never touched.

The stack memory after this code is :
```
0
18
18
18
18
18
5
```

## Hello, World!

There is some possible `Hello, Word!` options

So, this is one possible code to how you can achieve it :

```
.u*9*8C;u*9*9u*9u*9uuCu*7CCu*3C;u*9*4u*8C;W;u*9*9u*6C;u*9*9u*9u*9u*9u*3Cu*3Cd*6Cd*8C;u*6*5u*3C

output : Hello, World!
```




