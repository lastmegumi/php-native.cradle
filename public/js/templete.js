const e = React.createElement;
const Router = ReactRouterDOM.BrowserRouter;
const Route =  ReactRouterDOM.Route;
const Link = ReactRouterDOM.Link;

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
        <div className="p-3 center-align">
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
    this.state = {reveiwed: false,
                  rating: 1,
                  reviews:[],
                  page_index: 1}
    this.handleChange = this.handleChange.bind(this);
    this.handleSubmit = this.handleSubmit.bind(this);
    this.appendReviews = this.appendReviews.bind(this);
    this.page = this.page.bind(this);
    this.pageNext = this.pageNext.bind(this);
    this.pagePrev = this.pagePrev.bind(this);
  }

  loadReview(pid){ 
    let x = new ume();
    let data = {product_id: pid,
                page: this.state.page_index}
    x.getReview(data).done(this.appendReviews);
  }

  appendReviews(data){
    ReactDOM.render(<Review {...data} />, document.getElementById('review_block'));
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
    this.setState({reviewed : true, page_index : this.props.pages}, () =>{
      this.loadReview(this.props.product_id);
    });
    return false
  }

  review_form(){
    if(this.state.reviewed){
      return <p className="center">Thank you for review</p>
    }else{
    return  <form onSubmit={this.handleSubmit}>
      <hr/>
      <h6>Write your comment</h6>
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

  handlePageClick(index){
    this.setState({page_index : index}, () => {
      this.loadReview(this.props.product_id);
    });
  }

  pagePrev(){
      this.setState({page_index : Math.max(this.state.page_index - 1, 1)}, () => {
       this.loadReview(this.props.product_id);
      });
  }

  pageNext(){
    this.setState({page_index : Math.min(this.state.page_index + 1, this.props.pages)}, () => {
      this.loadReview(this.props.product_id);
    });
  }

  page(){
    let rows = []
    for (let i = 1; i <= this.props.pages; i++) {
      rows.push(<li key={i} className={this.state.page_index == i? "active": "waves-effect grey lighten-4"}>
        <a onClick={() => this.handlePageClick(i)} href="#!">{i}</a>
        </li>)
    }
    return <div>
        <ul className="pagination">
        <li className={this.state.page_index == 1? "disabled" : "waves-effect grey lighten-4"}>
          <a href="#!"><i className="material-icons" onClick={this.pagePrev}>chevron_left</i></a></li>
        {rows}
        <li className={this.state.page_index == this.props.pages? "disabled" : "waves-effect  grey lighten-4"}>
          <a href="#!"><i className="material-icons" onClick={this.pageNext}>chevron_right</i></a></li>
        </ul>
        </div>
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
              <div className="">
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

        {this.page()}
        {this.review_form()}
        </div>
      );
    }
  }
}

class Product extends React.Component{
  constructor(props){
    super(props);
    this.state = {page_index : this.props? this.props.page_index: 1, first_load :true}
    this.loadData = this.loadData.bind(this);
    this.appendDatato = this.appendDatato.bind(this);
    this.addtoCart = this.addtoCart.bind(this);
    this.page = this.page.bind(this);
    this.pagePrev = this.pagePrev.bind(this);
    this.pageNext = this.pageNext.bind(this);
  }

  componentWillMount () {
    // if(!this.state.first_load){return;}
    // let values = this.props.location.search.substr(1).split("&");
    // let query = {};
    // for(let i = 0; i < values.length; i++){
    //   let key = values[i].split("=")[0];
    //   let value = values[i].split("=")[1];
    //   query[key] = value;
    // }
    // if(query.page){
    //   this.setState({page_index: query.apage});
    // }
    // this.setState({first_load: false});
  }
  componentWillReceiveProps(nextProps){
     //call your api and update state with new props
     console.log(nextProps.location.pathname)    // path/to/abc
  }

  componentDidMount(){
    this.setState({first_loaded: true, page_index: this.props.page_index})
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

    handlePageClick(index){
    this.setState({page_index : index}, () => {
      this.loadData();
    });
  }

  pagePrev(){
      this.setState({page_index : Math.max(this.state.page_index - 1, 1)}, () => {
       this.loadData();
      });
  }

  pageNext(){
    this.setState({page_index : Math.min(this.state.page_index + 1, this.props.pages)}, () => {
      this.loadData();
    });
  }

  page(){
    let rows = []
    for (let i = 1; i <= this.props.pages; i++) {
      if(i < this.state.page_index - 5){continue;}
      if(i > this.state.page_index + 5){continue;}
      rows.push(<li key={i} className={this.state.page_index == i? "active": "waves-effect grey lighten-4"}>
        <a onClick={() => this.handlePageClick(i)} href>{i}</a>
        </li>)
    }
    return <div>
        <ul className="pagination">
        <li className={this.state.page_index == 1? "disabled" : "waves-effect grey lighten-4"}>
          <a href><i className="material-icons" onClick={this.pagePrev}>chevron_left</i></a></li>
        {rows}
        <li className={this.state.page_index == this.props.pages? "disabled" : "waves-effect  grey lighten-4"}>
          <a href><i className="material-icons" onClick={this.pageNext}>chevron_right</i></a>
            </li>
        </ul>
        </div>
  }

  view_Grid(){
    return (<div>
        <div>
          {this.page()}
          </div>
          <div className="row view_grid">
          {this.props.items.map((item, i)  =>  {
          return <div className="col s3 small" key={item.id}>  
              <div className="product_block">
                <div className="card">
                  <div className="card-image">
                    <img className="img-responsive lazy" src={item.thumbnail} />
                    <span className="card-title"></span>
                  </div>
                  <div className="card-content pos-relative">
                  <a href={item.url}>          
                    <p className="product_name">{item.name}</p>
                  </a>
                  {item.forsale &&
                      <a className="right btn-floating waves-effect waves-light red add-to-cart" id="add-to-cart" data-id={item.id}
                      onClick={() => this.addtoCart(item.id)}>
                      <i className="material-icons">add</i></a>
                    }
                    <p>{item.price.currency} {item.price.amount}</p>
                    <a href={item.seller.url}><span className="grey-text text-darken-3">Seller: {item.seller.name}</span></a>
                  </div>
                </div>
              </div>
          </div>
        })}
          </div>
          <div>
          {this.page()}
          </div>
          <p className="right">Total: {this.props.total} Items</p>
          </div>
    )
  }

  loadData(){ 
    let data
    if(this.state.first_loaded !== true){
      let url_string = window.location.href; //window.location.href
      let url = new URL(url_string);
      let page_i = url.searchParams.get("page");
      data = {page : page_i}
    }else{
      data = {page : this.state.page_index}
    }

      let x = new ume();
      x.getProduct(data).done(this.appendDatato);

  }

  appendDatato(data){
    //ReactDOM.render(<Product {...data} />, document.getElementById('product_block'));
    ReactDOM.render(<React.Fragment>
                    <Router>
                      <Route path="/:page/:id?:filter" component={({ match }) => <Product {...data} match = {match} location = {location}/>} />
                    </Router>
                    </React.Fragment>, document.getElementById('product_block'));

      if(this.state.page_index != 1){
        let uri = act.prototype.updateQueryStringParameter(window.location.href, "page", this.state.page_index)
        window.history.pushState(null, "", uri );
      }else{        
        let uri = act.prototype.removeURLParameter(window.location.href, "page")
        window.history.pushState(null, "", uri );
      }
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
