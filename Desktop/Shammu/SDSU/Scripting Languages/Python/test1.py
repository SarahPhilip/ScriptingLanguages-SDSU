def fib(n):
    a, b= 0, 1
    while a < n:
        print (a, end=' ')
        a, b = b, a+b
    print()

fString = input('Enter the number : ')
print(fString)
fib(1000)
f = int(fString)
fib(f)
