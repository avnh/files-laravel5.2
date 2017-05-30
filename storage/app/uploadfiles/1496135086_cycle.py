# n, x = map(int, raw_input().split(' '))
n,x = 6,11

c = list(bin(x)).count('1')
# print c, bin(x)
for i in range(n):
	x+=x
	if list(bin(x)).count('1')!=c:
		break
	