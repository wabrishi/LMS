import os
from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy

app = Flask(__name__)

# Configuration
app.config['SQLALCHEMY_DATABASE_URI'] = os.environ.get('DATABASE_URL', 'postgresql://user:password@localhost:5432/products_db')
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

db = SQLAlchemy(app)

# Model
class Product(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    name = db.Column(db.String(100), nullable=False)
    # Using Float for simplicity in this demo, but Numeric/Decimal is preferred for real currency
    price = db.Column(db.Numeric(10, 2), nullable=False)
    description = db.Column(db.String(255), nullable=True)

    def to_dict(self):
        return {
            'id': self.id,
            'name': self.name,
            'price': float(self.price), # Convert Decimal to float for JSON
            'description': self.description
        }

# Create tables
@app.before_first_request
def create_tables():
    db.create_all()

@app.route('/', methods=['GET'])
def health_check():
    return "Product Service is running"

# List Products
@app.route('/products', methods=['GET'])
def get_products():
    products = Product.query.all()
    return jsonify([p.to_dict() for p in products])

# Create Product
@app.route('/products', methods=['POST'])
def create_product():
    data = request.get_json()
    if not data or not 'name' in data or not 'price' in data:
        return jsonify({'message': 'Name and price are required'}), 400

    new_product = Product(name=data['name'], price=data['price'], description=data.get('description', ''))
    db.session.add(new_product)
    db.session.commit()

    return jsonify(new_product.to_dict()), 201

# Get Single Product
@app.route('/products/<int:id>', methods=['GET'])
def get_product(id):
    product = Product.query.get_or_404(id)
    return jsonify(product.to_dict())

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)
