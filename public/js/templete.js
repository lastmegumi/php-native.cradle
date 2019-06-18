const e = React.createElement;
class Topshoppingcart extends React.Component {
  constructor(props) {
    super(props);
    this.state = { liked: false };
  }

  buildcart(){
  }

  render() {
    if (this.state.liked) {
      return 'You liked this.';
    }
    if(!this.props.data){
      return(
        <div className="p-3">
        Empty Cart</div>
        );
    }
    return (
      <div>
        <ul className="collection top-cart-list">
          {this.props.data.items.map((item, i) => {
            return <li className="collection-item avatar" key={i}>
                  <img className="circle" src={item.thumbnail} />
                  <span className="title">{item.name}</span>
                  <span className="small red-text text-lighten-2 left bold">${item.price}</span>
                  <span className="small right">{item.qty}</span>
              </li>
          })}
        </ul>
        <div className="p-3"><span>Subtotal:</span><span className="right">${this.props.data.subtotal}</span></div>
        <a className="waves-effect waves-light red lighten-2 btn right" href="/cart/mycart"><i className="material-icons left">shopping_basket</i>Check Out</a>
      </div>
      );
  }
}

class Review extends React.Component{
  constructor(props){
    super(props);
    this.state = {reveiwed: false, rating: 1, reviews:[]}
    this.handleChange = this.handleChange.bind(this);
    this.handleSubmit = this.handleSubmit.bind(this);
    this.appendReviews = this.appendReviews.bind(this);
  }

  loadReview(pid){ 
    let x = new ume();
    let data = {product_id: pid}
    x.getReview(data).done(this.appendReviews);
  }

  appendReviews(data){
    ReactDOM.render(e(Review, data), document.getElementById('review_block'));
  }

  handleRating(rating){
    this.setState({rating: rating});
  }

  handleChange(event){
    this.setState({review : event.target.value});
  }

  handleSubmit(event){
    event.preventDefault();
    let data = {product_id : this.props.product_id,
                content : this.state.review,
                rate : this.state.rating}
    let x = new ume();
    x.addReview(data);
    this.setState({reviewed : true});
    this.loadReview(this.props.product_id);
    return false
  }

  review_form(){
    if(this.state.reviewed){
      return <h2>Thank you for review</h2>
    }else{
    return  <form onSubmit={this.handleSubmit}>
      <div className="row">
        <div className="col s12">
          <a href="javascript:void(0)" onClick={() => this.handleRating(1)} className={this.state.rating >= 1? "red-text text-lighten-2":"grey-text text-lighten-2" }><i className="material-icons dp48">star</i></a>
          <a href="javascript:void(0)" onClick={() => this.handleRating(2)} className={this.state.rating >= 2? "red-text text-lighten-2":"grey-text text-lighten-2" }><i className="material-icons dp48">star</i></a>
          <a href="javascript:void(0)" onClick={() => this.handleRating(3)} className={this.state.rating >= 3? "red-text text-lighten-2":"grey-text text-lighten-2" }><i className="material-icons dp48">star</i></a>
          <a href="javascript:void(0)" onClick={() => this.handleRating(4)} className={this.state.rating >= 4? "red-text text-lighten-2":"grey-text text-lighten-2" }><i className="material-icons dp48">star</i></a>
          <a href="javascript:void(0)" onClick={() => this.handleRating(5)} className={this.state.rating >= 5? "red-text text-lighten-2":"grey-text text-lighten-2" }><i className="material-icons dp48">star</i></a>
          <div className="row">
            <div className="input-field col s12">
              <i className="material-icons prefix">mode_edit</i>
              <textarea rows="4" id="icon_prefix2" className="materialize-textarea" name="content" value={this.state.value} onChange={this.handleChange}></textarea>
              <label for="icon_prefix2">Your Comment</label>
            </div>
          </div>
          <button className="btn right" type="submit" value="Submit">Submit</button>
        </div>
      </div>
      </form>
    }
  }

  render(){
    if(!this.props.data ||this.props.data.length < 1){
      return this.review_form()
    }else{
      return(
        <div className="reviews">
        {this.props.data.map((item, i)  =>  {
          return <div className="row" key={item.id}>
            <div className="col s12">
              <div className="p-3">
              {(() => {
                switch (item.rate) {
                          case 1:
                            return <span><i className="material-icons dp48 red-text text-lighten-2">star</i>
                              <i className="material-icons dp48 grey-text text-lighten-2">star</i>
                              <i className="material-icons dp48 grey-text text-lighten-2">star</i>
                              <i className="material-icons dp48 grey-text text-lighten-2">star</i>
                              <i className="material-icons dp48 grey-text text-lighten-2">star</i></span>;
                            break;
                          case 2:
                            return <span><i className="material-icons dp48 red-text text-lighten-2">star</i>
                              <i className="material-icons dp48 red-text text-lighten-2">star</i>
                              <i className="material-icons dp48 grey-text text-lighten-2">star</i>
                              <i className="material-icons dp48 grey-text text-lighten-2">star</i>
                              <i className="material-icons dp48 grey-text text-lighten-2">star</i></span>;
                            break;
                          case 3:
                            return <span><i className="material-icons dp48 red-text text-lighten-2">star</i>
                              <i className="material-icons dp48 red-text text-lighten-2">star</i>
                              <i className="material-icons dp48 red-text text-lighten-2">star</i>
                              <i className="material-icons dp48 grey-text text-lighten-2">star</i>
                              <i className="material-icons dp48 grey-text text-lighten-2">star</i></span>;
                            break;
                          case 4:
                            return <span><i className="material-icons dp48 red-text text-lighten-2">star</i>
                              <i className="material-icons dp48 red-text text-lighten-2">star</i>
                              <i className="material-icons dp48 red-text text-lighten-2">star</i>
                              <i className="material-icons dp48 red-text text-lighten-2">star</i>
                              <i className="material-icons dp48 grey-text text-lighten-2">star</i></span>;
                            break;
                          case 5:       
                          default:
                            return <span><i className="material-icons dp48 red-text text-lighten-2">star</i>
                              <i className="material-icons dp48 red-text text-lighten-2">star</i>
                              <i className="material-icons dp48 red-text text-lighten-2">star</i>
                              <i className="material-icons dp48 red-text text-lighten-2">star</i>
                              <i className="material-icons dp48 red-text text-lighten-2">star</i></span>;
                            break;
                }
              })()}
                <span className="right">{item.date}</span>
                <p>{item.content}</p>
                <span>{item.user.name}</span>
              </div>
            </div>
          </div>
        })}
        {this.review_form()}
        </div>
      );
    }
  }
}

class Product extends React.Component{
  constructor(props){
    super(props);
    this.state = {}
    this.appendDatato = this.appendDatato.bind(this);
    this.addtoCart = this.addtoCart.bind(this);
  }

  addtoCart(pid){
    event.preventDefault();
    let data = {};
    data.pid = pid;
    data.quantity = this.state.quantity? this.state.quantity:1;
    let x = new ume()
    x.addtocart(data).done(this.tips);
    return false;
  }

  tips(data){
    data = data ? data : "Complete";
    M.toast({html: data, classes: 'rounded'});
  }

  view_Grid(){
    return (<div>
          <div className="row">
          {this.props.items.map((item, i)  =>  {
          return <div className="col s3" key={item.id}>  
              <div className="product_block">
                <div className="card">
                  <div className="card-image">
                    <img className="img-responsive lazy" src={item.thumbnail} />
                    <span className="card-title"></span>
                  </div>
                  <div className="card-content">
                  <a href={item.url}>          
                    <p className="product_name">{item.name}</p>
                  </a>
                  {item.forsale &&
                      <a className="right btn-floating waves-effect waves-light red add-to-cart" id="add-to-cart" data-id={item.id}
                      onClick={() => this.addtoCart(item.id)}>
                      <i className="material-icons">add</i></a>
                    }
                    <p>{item.price.currency} {item.price.amount}</p>
                  </div>
                </div>
              </div>
          </div>
        })}
          </div>
          <p>Total: {this.props.items.length} Items</p>
          </div>
    )
  }

  loadData(){    
    let x = new ume();
    let data = {}
    x.getProduct(data).done(this.appendDatato);
  }

  appendDatato(data){
    ReactDOM.render(e(Product, data), document.getElementById('product_block'));
  }

  render(){
    return this.view_Grid()
  }
}



class Email extends React.Component{
  constructor(props){
    super(props);
    this.state = {email : null,
                subject : null,
                message : null};
  }

  renderForm(data){
    ReactDOM.render(e(Email, data), document.getElementById('email_support'));
  }

  handleEmail(event){
    this.setState({email : event.target.value});
  }
  handleSubject(event){
    this.setState({subject : event.target.value});
  }
  handleMessage(event){
    this.setState({message : event.target.value});
  }


  handleSubmit(event){
    event.preventDefault();

    if(!this.state.email || !this.state.subject || !this.state.message){
      alert("input cannot be empty");
      return false;
    }

    let x = new ume();
    let data = {email : this.state.email,
                subject : this.state.subject,
                message : this.state.message};
    x.sendMail(data).done(this.Sent());
    return false;
  }

  Sent(){
    this.setState({sent : true});
  }

  SentMessage(){
    return <p className="center">Thank you, we will contact you soon!</p>
  }

  render(){
    if(this.state.sent){
      return this.SentMessage()
    }else{

    return <form className="col s12" onSubmit={this.handleSubmit.bind(this)}>
            <div className="row">
              <div className="input-field col s12">
                <input onChange={this.handleSubject.bind(this)} id="name" type="text" className="validate" />
                <label for="name">Subject</label>
              </div>
              <div className="input-field col s12">
                <input onChange={this.handleEmail.bind(this)} id="email" type="text" className="validate" />
                <label for="email">E-mail</label>
              </div>
            </div>
            <div className="row">
              <div className="input-field col s12 width-100">
                <textarea onChange={this.handleMessage.bind(this)} id="textarea1" className="materialize-textarea"></textarea>
                <label for="textarea1">Textarea</label>
                <button className="waves-effect waves-light btn">Send</button>
              </div>
            </div>
          </form>
        }
  }
}



