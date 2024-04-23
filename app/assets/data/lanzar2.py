import json
import time
import argparse

import argparse
parser = argparse.ArgumentParser()
parser.add_argument("a")
parser.add_argument("b")
args = parser.parse_args()
time.sleep(3)

print ("%s_%s" % (args.a,args.b))
