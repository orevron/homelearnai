import fs from 'fs';
import path from 'path';

function walkDir(dir, callback) {
    fs.readdirSync(dir).forEach(f => {
        let dirPath = path.join(dir, f);
        let isDirectory = fs.statSync(dirPath).isDirectory();
        isDirectory ? walkDir(dirPath, callback) : callback(path.join(dir, f));
    });
}

function replaceClasses(content) {
    return content
        // Margins
        .replace(/\bml-([0-9a-z\.-]+)/g, 'ms-$1')
        .replace(/\bmr-([0-9a-z\.-]+)/g, 'me-$1')
        .replace(/-ml-([0-9a-z\.-]+)/g, '-ms-$1')
        .replace(/-mr-([0-9a-z\.-]+)/g, '-me-$1')
        // Paddings
        .replace(/\bpl-([0-9a-z\.-]+)/g, 'ps-$1')
        .replace(/\bpr-([0-9a-z\.-]+)/g, 'pe-$1')
        // Text alignment
        .replace(/\btext-left\b/g, 'text-start')
        .replace(/\btext-right\b/g, 'text-end')
        // Borders
        .replace(/\bborder-l-([0-9a-z\.-]+)/g, 'border-s-$1')
        .replace(/\bborder-r-([0-9a-z\.-]+)/g, 'border-e-$1')
        .replace(/\bborder-l\b/g, 'border-s')
        .replace(/\bborder-r\b/g, 'border-e')
        // BorderRadius
        .replace(/\brounded-l-([0-9a-z\.-]+)/g, 'rounded-s-$1')
        .replace(/\brounded-r-([0-9a-z\.-]+)/g, 'rounded-e-$1')
        .replace(/\brounded-l\b/g, 'rounded-s')
        .replace(/\brounded-r\b/g, 'rounded-e')
        // Positioning
        .replace(/\bleft-([0-9a-z\.-]+)/g, 'start-$1')
        .replace(/\bright-([0-9a-z\.-]+)/g, 'end-$1')
        .replace(/-left-([0-9a-z\.-]+)/g, '-start-$1')
        .replace(/-right-([0-9a-z\.-]+)/g, '-end-$1')
        .replace(/\bleft-0\b/g, 'start-0')
        .replace(/\bright-0\b/g, 'end-0');
}

['resources/views', 'resources/js'].forEach(dir => {
    if (!fs.existsSync(dir)) return;
    walkDir(dir, (filePath) => {
        if (filePath.endsWith('.blade.php') || filePath.endsWith('.js') || filePath.endsWith('.vue')) {
            let content = fs.readFileSync(filePath, 'utf8');
            let newContent = replaceClasses(content);
            if (content !== newContent) {
                fs.writeFileSync(filePath, newContent);
                console.log(`Updated ${filePath}`);
            }
        }
    });
});
