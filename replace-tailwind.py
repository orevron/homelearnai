import os
import re

def replace_classes(content):
    # Margins
    content = re.sub(r'\bml-([0-9a-z.-]+)', r'ms-\1', content)
    content = re.sub(r'\bmr-([0-9a-z.-]+)', r'me-\1', content)
    content = re.sub(r'-ml-([0-9a-z.-]+)', r'-ms-\1', content)
    content = re.sub(r'-mr-([0-9a-z.-]+)', r'-me-\1', content)
    # Paddings
    content = re.sub(r'\bpl-([0-9a-z.-]+)', r'ps-\1', content)
    content = re.sub(r'\bpr-([0-9a-z.-]+)', r'pe-\1', content)
    # Text alignment
    content = re.sub(r'\btext-left\b', 'text-start', content)
    content = re.sub(r'\btext-right\b', 'text-end', content)
    # Borders
    content = re.sub(r'\bborder-l-([0-9a-z.-]+)', r'border-s-\1', content)
    content = re.sub(r'\bborder-r-([0-9a-z.-]+)', r'border-e-\1', content)
    content = re.sub(r'\bborder-l\b', 'border-s', content)
    content = re.sub(r'\bborder-r\b', 'border-e', content)
    # BorderRadius
    content = re.sub(r'\brounded-l-([0-9a-z.-]+)', r'rounded-s-\1', content)
    content = re.sub(r'\brounded-r-([0-9a-z.-]+)', r'rounded-e-\1', content)
    content = re.sub(r'\brounded-l\b', 'rounded-s', content)
    content = re.sub(r'\brounded-r\b', 'rounded-e', content)
    # Positioning
    content = re.sub(r'\bleft-([0-9a-z.-]+)', r'start-\1', content)
    content = re.sub(r'\bright-([0-9a-z.-]+)', r'end-\1', content)
    content = re.sub(r'-left-([0-9a-z.-]+)', r'-start-\1', content)
    content = re.sub(r'-right-([0-9a-z.-]+)', r'-end-\1', content)
    content = re.sub(r'\bleft-0\b', 'start-0', content)
    content = re.sub(r'\bright-0\b', 'end-0', content)
    return content

for directory in ['resources/views', 'resources/js']:
    for root, _, files in os.walk(directory):
        for file in files:
            if file.endswith('.blade.php') or file.endswith('.js') or file.endswith('.vue'):
                filepath = os.path.join(root, file)
                with open(filepath, 'r+', encoding='utf-8') as f:
                    content = f.read()
                    new_content = replace_classes(content)
                    if content != new_content:
                        f.seek(0)
                        f.write(new_content)
                        f.truncate()
                        print(f"Updated {filepath}")
