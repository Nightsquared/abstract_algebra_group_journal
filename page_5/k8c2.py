#common setup (variable definitions)
#import group data from the uploaded csv
import pandas as pd
import numpy as np
df = pd.read_csv (r'https://alexscully.com/archive/aa_group_journal/K8C2.csv', header = None)
_group = df.to_numpy()

#define list of elements
elements = [i for i in _group[0]];

#define lookup dicts
_lookup = {_group[0][i]:i for i in range(len(_group))}
_rlookup = {i:_group[0][i] for i in range(len(_group))}

#create and fill _group table dictionary
_groupdict = {}
for i in range(len(_group)):
    subdict = {}
    for j in range(len(_group)):
        subdict.update({_rlookup[j]:_group[i][j]})
    _groupdict.update({_rlookup[i]:subdict})
    
#define function using _groupdict (should make reading code easier)
def f(a, b):
    global _groupdict, elements
    assert a in elements, str(a) + " is not an element."
    assert b in elements, str(b) + " is not an element."
    return _groupdict[str(a)][str(b)]
    
#define identity so it's clear what I'm referring to in code
e = _group[0][0]

#create and fill inverses dictionary
inverses = {}
for a in elements:
    for b in elements:
        if f(a, b) == e and f(b, a) == e:
            inverses.update({a:b})

#define inverse function
def inverse(a):
    global inverses, elements
    assert a in elements, str(a) + " is not an element."
    return inverses[str(a)]

#calculate subgroups
_alladded = [e]
_candidate_elements = []
for a in elements:
    if not a in _alladded:
        thiscandidate = [a]
        i = inverse(a)
        if i != a:
            thiscandidate.append(i)
        for b in thiscandidate:
            _alladded.append(b)
        _candidate_elements.append(thiscandidate)

_candidates = []
for i in range(2**len(_candidate_elements)):
    thiscandidate = [e]
    for j in range(len(_candidate_elements)):
        if (i>>j)%2 == 1:
            for k in _candidate_elements[j]:
                thiscandidate.append(k)
    _candidates.append(thiscandidate)

subgroups = []
for candidate in _candidates:
    isclosed = True
    for a in candidate:
        for b in candidate:
            if isclosed and f(a, b) not in candidate:
                isclosed = False
    if isclosed:
        subgroups.append(candidate)

center = []
centralizers = {}
for a in elements:
    centralizer = []
    isincenter = True
    for x in elements:
        if f(a, x) == f(x, a):
            centralizer.append(x)
        else:
            isincenter = False
    centralizers.update({a:centralizer})
    if isincenter:
        center.append(a)
        
#define centralizer function
def centralizer(a):
    global centralizers, elements
    assert a in elements, str(a) + " is not an element."
    return centralizers[str(a)]

cyclics = {}
for a in elements:
    currentval = a
    cyclic = [a]
    while currentval != e:
        currentval = f(currentval, a)
        cyclic.append(currentval)
    cyclics.update({a:cyclic})
    
def cyclic(a):
    global cyclics, elements
    assert a in elements, str(a) + " is not an element."
    return cyclics[str(a)]