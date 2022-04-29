array = [2,7,11,15]  
target = 9

def twoSum(array, target) :
    values = dict()
        
    for i, total in enumerate(array):
        kom = target - total
            
        if kom in values:
            return [values[kom], i]
        values[total] = i
    return []

result = twoSum(array, target)
print(result)
            