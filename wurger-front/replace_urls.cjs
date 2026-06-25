const fs = require('fs');
const path = require('path');

const walkSync = (dir, filelist = []) => {
    fs.readdirSync(dir).forEach(file => {
        const dirFile = path.join(dir, file);
        if (fs.statSync(dirFile).isDirectory()) {
            filelist = walkSync(dirFile, filelist);
        } else {
            if (file.endsWith('.js') || file.endsWith('.jsx')) {
                filelist.push(dirFile);
            }
        }
    });
    return filelist;
};

const files = walkSync('d:/wurger/wurger-front/src');
files.forEach(file => {
    let content = fs.readFileSync(file, 'utf8');
    if (content.includes('http://localhost:8080')) {
        content = content.replace(/'http:\/\/localhost:8080([^']*)'/g, "`\\${import.meta.env.VITE_API_URL || 'http://localhost:8080'}$1`");
        content = content.replace(/"http:\/\/localhost:8080([^"]*)"/g, "`\\${import.meta.env.VITE_API_URL || 'http://localhost:8080'}$1`");
        content = content.replace(/`http:\/\/localhost:8080([^`]*)`/g, "`\\${import.meta.env.VITE_API_URL || 'http://localhost:8080'}$1`");
        
        fs.writeFileSync(file, content, 'utf8');
        console.log(`Updated ${file}`);
    }
});
