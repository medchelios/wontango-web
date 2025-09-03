#!/bin/bash

echo "🚀 Building WontanGo for production..."

# Nettoyer les anciens builds
echo "🧹 Cleaning old builds..."
rm -rf public/build

# Build en local
echo "🔨 Building assets..."
npm run build

# Vérifier que le build a réussi
if [ -d "public/build" ]; then
    echo "✅ Build successful!"
    echo "📁 Build files created in public/build/"
    
    # Créer une archive du build
    echo "📦 Creating archive..."
    cd public
    tar -czf ../wontango-build.tar.gz build/
    cd ..
    
    echo "🎉 Ready to upload!"
    echo ""
    echo "📋 Next steps:"
    echo "1. Upload wontango-build.tar.gz to your server"
    echo "2. Extract it in your public_html directory:"
    echo "   tar -xzf wontango-build.tar.gz"
    echo "3. Make sure the build folder is in the right place"
    echo ""
    echo "📊 Build size:"
    du -sh public/build/
    
else
    echo "❌ Build failed!"
    exit 1
fi
