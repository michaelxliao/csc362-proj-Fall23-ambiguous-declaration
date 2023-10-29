import os
from pathlib import Path

def setupFieldSpecFolder():
    # folder_path = "Tables_and_Fields_and_PKs/FieldSpecs" # field specs forms
    folder_path = "Business_Rules/Business_Rule_Forms" # business rule forms
    folder = Path(folder_path)
    files = folder.iterdir()
    return files

def createHeading(heading):
    return f"### {heading}\n"

if __name__ == "__main__":
    with open('result.txt', 'w') as res: # final file for output
        files = setupFieldSpecFolder()
        for file in files:
            with open(file, 'r') as readable_file:
                res.write(createHeading(os.path.basename(readable_file.name)))
                res.write(readable_file.read() + '\n')
    print("All done!")